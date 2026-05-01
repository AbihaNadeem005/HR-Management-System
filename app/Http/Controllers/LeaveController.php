<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveController extends Controller
{
    // Show Apply Leave Form
    public function showApplyForm()
    {
        $leave_types = LeaveType::all(); // match the view variable
        return view('leave.apply', compact('leave_types'));
    }

    // Leave History
    public function leaveHistory()
    {
        $leaves = LeaveRequest::all(); // rename to $leaves
        return view('leave.history', compact('leaves'));
    }

    // Leave Balance
public function leaveBalance(Request $request)
{
    $search = $request->input('search'); // Get search term from request
    $showAll = $request->input('show_all', false); // Get show_all parameter

    // Get all employees with valid IDs
    $employeesQuery = Employee::whereNotNull('Emp_ID')->where('Emp_ID', '!=', '');
    
    // Apply work location filter only if show_all is not set
    if (!$showAll) {
        $employeesQuery->where('Work_Location', 'Head Office');
    }
    
    // Apply search filter if provided
    if ($search) {
        $employeesQuery->where(function($query) use ($search) {
            $query->where('Name', 'LIKE', "%{$search}%")
                  ->orWhere('Emp_ID', 'LIKE', "%{$search}%");
        });
    }

    $employees = $employeesQuery->get();

    // Fetch final data for display
    $leaves = LeaveBalance::join('rwd', 'rwd.Emp_ID', '=', 'leave_balances.employee_id')
        ->select('rwd.Emp_ID', 'rwd.Name', 'rwd.Work_Location','leave_balances.*')
        ->when(!$showAll, function($query) {
            // Filter by Head Office if not showing all
            $query->where('rwd.Work_Location', 'Head Office');
        })
        ->when($search, function($query) use ($search) {
            // Apply the same search filter to leave_balances join result
            $query->where('rwd.Name', 'LIKE', "%{$search}%")
                  ->orWhere('rwd.Emp_ID', 'LIKE', "%{$search}%");
        })
        ->get()
        ->map(fn ($row) => (object)[
            'Emp_ID'           => $row->Emp_ID,
            'Name'             => $row->Name,
            'Work_Location'    => $row->Work_Location,
            'total_leaves'     => $row->total_allocated,
            'used_leaves'      => $row->used_leaves,
            'remaining_leaves' => $row->remaining_leaves,
            'casual_total'     => $row->casual_total,
            'casual_used'      => $row->casual_used,
            'casual_remaining' => $row->casual_total - $row->casual_used,
            'sick_total'       => $row->sick_total,
            'sick_used'        => $row->sick_used,
            'sick_remaining'   => $row->sick_total - $row->sick_used,
            'annual_total'     => $row->annual_total,
            'annual_used'      => $row->annual_used,
            'annual_remaining' => $row->annual_total - $row->annual_used
        ]);

    return view('leave.balance', compact('leaves', 'search', 'showAll'));
}

    public function updateLeaveTotals(Request $request)
    {
        $leave = LeaveBalance::firstOrCreate(['employee_id' => $request->employee_id]);

        $leave->casual_total = $request->casual_total ?? $leave->casual_total;
        $leave->sick_total   = $request->sick_total ?? $leave->sick_total;
        $leave->annual_total = $request->annual_total ?? $leave->annual_total;

        // Recalculate totals
        $leave->total_allocated  = $leave->casual_total + $leave->sick_total + $leave->annual_total;
        $leave->used_leaves      = $leave->casual_used + $leave->sick_used + $leave->annual_used;
        $leave->remaining_leaves = $leave->total_allocated - $leave->used_leaves;

        $leave->save();

        return response()->json(['success' => true, 'message' => 'Leave totals updated successfully']);
    }

    public function resetLeaves()
{
    // Reset all leave requests
    LeaveRequest::truncate();
    
    // Reset all leave balances - set used leaves back to 0
    LeaveBalance::query()->update([
        'casual_used' => 0,
        'sick_used' => 0,
        'annual_used' => 0,
        'used_leaves' => 0,
        'remaining_leaves' => DB::raw('total_allocated')
    ]);

    return response()->json(['success' => true, 'message' => 'All leaves have been reset successfully']);
}

    private function calculateDays($startDate, $endDate)
    {
        return Carbon::parse($startDate)
            ->diffInDays(Carbon::parse($endDate)) + 1;
    }

    // Show the create form
    public function create(Request $request)
    {
        $employeeId   = $request->query('employee_id');
        $employeeName = $request->query('employee_name');

        // Fetch leave types from DB
        $leave_types = LeaveType::all();

        return view('leave.apply', compact('employeeId', 'employeeName', 'leave_types'));
    }

   private function recalculateLeaveBalance($employeeId)
{
    // Fetch or create leave balance record
    $leaveBalance = LeaveBalance::firstOrCreate(
        ['employee_id' => $employeeId],
        [
            'casual_total' => 10,
            'sick_total'   => 10,
            'annual_total' => 20
        ]
    );

    // Fetch all approved leaves for this employee
    $approvedLeaves = LeaveRequest::where('employee_id', $employeeId)
        ->whereRaw("TRIM(LOWER(status)) = ?", ['approved'])
        ->get();

    // Fetch leave types from DB (dynamic, in case they change)
    $leaveTypes = LeaveType::all()->keyBy(function($lt){
        return strtolower(trim($lt->name)); // lowercase for easy matching
    });

    // Initialize used counts
    $used = [
        'casual leave' => 0,
        'sick leave'   => 0,
        'annual leave' => 0,
    ];

    // Calculate used days for each leave type
    foreach ($approvedLeaves as $leave) {
        $type = strtolower(trim($leave->leave_type));
        if(isset($used[$type])){
            $used[$type] += $this->calculateDays($leave->start_date, $leave->end_date);
        }
    }

    // Update leaveBalance with used leaves
    $leaveBalance->casual_used  = $used['casual leave'];
    $leaveBalance->sick_used    = $used['sick leave'];
    $leaveBalance->annual_used  = $used['annual leave'];

    // Make sure totals are from DB leave types (dynamic)
    $leaveBalance->casual_total = $leaveTypes['casual leave']->max_days ?? 10;
    $leaveBalance->sick_total   = $leaveTypes['sick leave']->max_days ?? 10;
    $leaveBalance->annual_total = $leaveTypes['annual leave']->max_days ?? 20;

    // Recalculate overall totals
    $leaveBalance->total_allocated  = $leaveBalance->casual_total + $leaveBalance->sick_total + $leaveBalance->annual_total;
    $leaveBalance->used_leaves      = $leaveBalance->casual_used + $leaveBalance->sick_used + $leaveBalance->annual_used;
    $leaveBalance->remaining_leaves = $leaveBalance->total_allocated - $leaveBalance->used_leaves;

    // Save updated leave balance
    $leaveBalance->save();
}


    // Store the leave request
   public function store(Request $request)
{
    $request->validate([
        'employee_id'   => 'required|string|max:20',
        'employee_name' => 'required|string|max:100',
        'leave_type'    => 'required|string',
        'start_date'    => 'required|date',
        'end_date'      => 'required|date|after_or_equal:start_date',
        'status'        => 'required|in:Pending,Approved,Rejected',
        'reason'        => 'nullable|string',
    ], [
        'leave_type.required' => 'Please select a leave type.',
        'end_date.after_or_equal' => 'End date must be after or equal to start date.'
    ]);

    $leave = LeaveRequest::create([
        'employee_id'   => $request->employee_id,
        'employee_name' => $request->employee_name,
        'leave_type'    => $request->leave_type,
        'start_date'    => $request->start_date,
        'end_date'      => $request->end_date,
        'status'        => $request->status,
        'reason'        => $request->reason,
    ]);

    // Only recalculate leave balance if the leave is approved
    if ($leave->status === 'Approved') {
        $this->recalculateLeaveBalance($leave->employee_id);
    }

    // Stay on the same page and show message
    return back()->with('success', 'Leave submitted successfully!');
}

   public function editApply($id)
{
    $leave = LeaveRequest::findOrFail($id);
    $leave_types = LeaveType::all();
    
    $employeeId = $leave->employee_id;
    $employeeName = $leave->employee_name;

    // Fetch leave balance for this employee
    $leaveBalance = LeaveBalance::where('employee_id', $employeeId)->first();

    $leaveBalances = [];

    if ($leaveBalance) {
        $leaveBalances[] = [
            'employee_id'      => $employeeId,
            'casual_remaining' => $leaveBalance->casual_total - $leaveBalance->casual_used,
            'sick_remaining'   => $leaveBalance->sick_total - $leaveBalance->sick_used,
            'annual_remaining' => $leaveBalance->annual_total - $leaveBalance->annual_used,
        ];
    }

    return view('leave.apply', compact('leave', 'leave_types', 'employeeId', 'employeeName', 'leaveBalances'));
}


    public function updateApply(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->leave_type = $request->leave_type;
        $leave->start_date = $request->start_date;
        $leave->end_date   = $request->end_date;
        $leave->status     = $request->status;
        $leave->reason     = $request->reason;
        $leave->save();

        // Recalculate leave balance
        $this->recalculateLeaveBalance($leave->employee_id);

        return redirect()->route('leave.history')
                        ->with('success', 'Leave updated successfully!');
    }

}
