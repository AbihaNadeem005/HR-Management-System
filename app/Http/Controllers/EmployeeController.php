<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class EmployeeController extends Controller
{
    // Display all employees with optional search
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('Name', 'LIKE', $search . '%')
                  ->orWhere('CNIC', 'like', $search . '%')
                  ->orWhere('Department', 'like', $search . '%')
                  ->orWhere('Emp_ID', 'like', $search . '%')
                  ->orWhere('Work_Location', 'like', $search . '%');
            });
        }

        $employees = $query->get();
        return view('employees.index', compact('employees'));
    }

    // Show form to add new employee
    public function create()
    {
        return view('employees.create');
    }

    // Store new employee
    public function store(Request $request)
    {
        $rules = [
            'CNIC' => 'required|digits:13|unique:rwd,CNIC',
            'Emp_ID' => 'nullable|string|max:50',
            'Name' => 'required|string|max:255',
            'Father_name' => 'nullable|string|max:255',
            'Gender' => 'nullable|in:Male,Female',
            'DOB' => 'nullable|date|before:today',
            'Religion' => 'nullable|string|max:50',
            'Nationality' => 'nullable|string|max:50',
            'Qualification' => 'nullable|string|max:100',
            'Domicile' => 'nullable|string|max:50',
            'District' => 'nullable|string|max:50',
            'Present_Home_Address' => 'nullable|string|max:255',
            'Permanent_Home_Address' => 'nullable|string|max:255',
            'Phone_no' => ['nullable', 'max:20', 'regex:/^\+?[0-9]+$/'],
            'Email' => 'nullable|string|max:100',
            'Date_of_joining' => 'nullable|date',
            'Job_Type' => 'nullable|string|max:50',
            'Designation' => 'nullable|string|max:100',
            'Department' => 'nullable|string|max:100',
            'Work_Location' => 'nullable|string|max:100',
            'Source_of_Funding' => 'nullable|string|max:100',
            'Starting_Salary' => 'nullable|numeric|min:0',
            'Current_Salary' => 'nullable|numeric|min:0',
            'Probation_Ending_Date' => 'nullable|date|after_or_equal:Date_of_joining',
            'Date_of_Leaving' => 'nullable|date|after_or_equal:Date_of_joining',
            'Final_Settlement' => ['nullable','string','regex:/^[A-Za-z\s]+$/'],
        ];

        $messages = [
            'CNIC.required' => 'CNIC is required.',
            'CNIC.digits' => 'CNIC must be exactly 13 digits.',
            'CNIC.unique' => 'This CNIC already exists.',
            'Emp_ID.string' => 'Employee ID must be text.',
            'Emp_ID.max' => 'Employee ID cannot exceed 50 characters.',
            'Name.required' => 'Full Name is required.',
            'Name.string' => 'Full Name must be text.',
            'Name.max' => 'Full Name cannot exceed 255 characters.',
            'Father_name.string' => 'Father\'s Name must be text.',
            'Father_name.max' => 'Father\'s Name cannot exceed 255 characters.',
            'Gender.in' => 'Gender must be either Male or Female.',
            'DOB.date' => 'Date of Birth must be a valid date.',
            'DOB.before' => 'Date of Birth must be before today.',
            'Religion.string' => 'Religion must be text.',
            'Religion.max' => 'Religion cannot exceed 50 characters.',
            'Nationality.string' => 'Nationality must be text.',
            'Nationality.max' => 'Nationality cannot exceed 50 characters.',
            'Qualification.string' => 'Qualification must be text.',
            'Qualification.max' => 'Qualification cannot exceed 100 characters.',
            'Domicile.string' => 'Domicile must be text.',
            'Domicile.max' => 'Domicile cannot exceed 50 characters.',
            'District.string' => 'District must be text.',
            'District.max' => 'District cannot exceed 50 characters.',
            'Present_Home_Address.string' => 'Present Home Address must be text.',
            'Present_Home_Address.max' => 'Present Home Address cannot exceed 255 characters.',
            'Permanent_Home_Address.string' => 'Permanent Home Address must be text.',
            'Permanent_Home_Address.max' => 'Permanent Home Address cannot exceed 255 characters.',
            'Phone_no.regex' => 'Phone Number must be valid and contain 10-20 digits (No symbol except +).',
            'Email.string' => 'Email must be text.',
            'Email.max' => 'Email cannot exceed 100 characters.',
            'Date_of_joining.date' => 'Date of Joining must be a valid date.',
            'Job_Type.string' => 'Job Type must be text.',
            'Job_Type.max' => 'Job Type cannot exceed 50 characters.',
            'Designation.string' => 'Designation must be text.',
            'Designation.max' => 'Designation cannot exceed 100 characters.',
            'Department.string' => 'Department must be text.',
            'Department.max' => 'Department cannot exceed 100 characters.',
            'Work_Location.string' => 'Work Location must be text.',
            'Work_Location.max' => 'Work Location cannot exceed 100 characters.',
            'Source_of_Funding.string' => 'Source of Funding must be text.',
            'Source_of_Funding.max' => 'Source of Funding cannot exceed 100 characters.',
            'Starting_Salary.numeric' => 'Starting Salary must be a number.',
            'Starting_Salary.min' => 'Starting Salary cannot be negative.',
            'Current_Salary.numeric' => 'Current Salary must be a number.',
            'Current_Salary.min' => 'Current Salary cannot be negative.',
            'Probation_Ending_Date.date' => 'Probation Ending Date must be a valid date.',
            'Probation_Ending_Date.after_or_equal' => 'Probation Ending Date cannot be before Date of Joining.',
            'Date_of_Leaving.date' => 'Date of Leaving must be a valid date.',
            'Date_of_Leaving.after_or_equal' => 'Date of Leaving cannot be before Date of Joining.',
            'Final_Settlement.string' => 'Final Settlement must be text only.',
            'Final_Settlement.regex' => 'Final Settlement can only contain letters and spaces.',
        ];

        $validatedData = $request->validate($rules, $messages);

        Employee::create($validatedData);

        return redirect()->route('employees.index')
            ->with('success', 'Employee added successfully!');
    }


    // Show form to edit employee
    public function edit($cnic)
    {
        $employee = Employee::where('CNIC', $cnic)->firstOrFail();

        $formatDate = function ($date) {
            try {
                return $date && strtotime($date) !== false
                    ? Carbon::parse($date)->format('Y-m-d')
                    : '';
            } catch (\Exception $e) {
                return '';
            }
        };

        $employee->DOB_formatted = $formatDate($employee->DOB);
        $employee->Date_of_joining_formatted = $formatDate($employee->Date_of_joining);
        $employee->Probation_Ending_Date_formatted = $formatDate($employee->Probation_Ending_Date);
        $employee->Date_of_Leaving_formatted = $formatDate($employee->Date_of_Leaving);

        return view('employees.edit', compact('employee'));
    }

    // Update employee
    public function update(Request $request, $cnic)
    {
        $employee = Employee::where('CNIC', $cnic)->firstOrFail();

        $rules = [
            'CNIC' => 'required|digits:13|unique:rwd,CNIC,' . $employee->CNIC . ',CNIC',
            'Emp_ID' => 'nullable|string|max:50',
            'Name' => 'required|string|max:255',
            'Father_name' => 'nullable|string|max:255',
            'Gender' => 'nullable|in:Male,Female',
            'DOB' => 'nullable|date|before:today',
            'Religion' => 'nullable|string|max:50',
            'Nationality' => 'nullable|string|max:50',
            'Qualification' => 'nullable|string|max:100',
            'Domicile' => 'nullable|string|max:50',
            'District' => 'nullable|string|max:50',
            'Present_Home_Address' => 'nullable|string|max:255',
            'Permanent_Home_Address' => 'nullable|string|max:255',
            'Phone_no' => ['nullable', 'max:20', 'regex:/^\+?[0-9]+$/'],
            'Email' => 'nullable|string|max:100',
            'Date_of_joining' => 'nullable|date',
            'Job_Type' => 'nullable|string|max:50',
            'Designation' => 'nullable|string|max:100',
            'Department' => 'nullable|string|max:100',
            'Work_Location' => 'nullable|string|max:100',
            'Source_of_Funding' => 'nullable|string|max:100',
            'Starting_Salary' => 'nullable|numeric|min:0',
            'Current_Salary' => 'nullable|numeric|min:0',
            'Probation_Ending_Date' => 'nullable|date|after_or_equal:Date_of_joining',
            'Date_of_Leaving' => 'nullable|date|after_or_equal:Date_of_joining',
            'Final_Settlement' => ['nullable', 'string', 'regex:/^[A-Za-z\s]+$/'],
        ];

        $messages = [
            'CNIC.required' => 'CNIC is required.',
            'CNIC.digits' => 'CNIC must be exactly 13 digits.',
            'CNIC.unique' => 'This CNIC already exists.',
            'Emp_ID.string' => 'Employee ID must be text.',
            'Emp_ID.max' => 'Employee ID cannot exceed 50 characters.',
            'Name.required' => 'Full Name is required.',
            'Name.string' => 'Full Name must be text.',
            'Name.max' => 'Full Name cannot exceed 255 characters.',
            'Father_name.string' => 'Father\'s Name must be text.',
            'Father_name.max' => 'Father\'s Name cannot exceed 255 characters.',
            'Gender.in' => 'Gender must be either Male or Female.',
            'DOB.date' => 'Date of Birth must be a valid date.',
            'DOB.before' => 'Date of Birth must be before today.',
            'Religion.string' => 'Religion must be text.',
            'Religion.max' => 'Religion cannot exceed 50 characters.',
            'Nationality.string' => 'Nationality must be text.',
            'Nationality.max' => 'Nationality cannot exceed 50 characters.',
            'Qualification.string' => 'Qualification must be text.',
            'Qualification.max' => 'Qualification cannot exceed 100 characters.',
            'Domicile.string' => 'Domicile must be text.',
            'Domicile.max' => 'Domicile cannot exceed 50 characters.',
            'District.string' => 'District must be text.',
            'District.max' => 'District cannot exceed 50 characters.',
            'Present_Home_Address.string' => 'Present Home Address must be text.',
            'Present_Home_Address.max' => 'Present Home Address cannot exceed 255 characters.',
            'Permanent_Home_Address.string' => 'Permanent Home Address must be text.',
            'Permanent_Home_Address.max' => 'Permanent Home Address cannot exceed 255 characters.',
            'Phone_no.regex' => 'Phone Number must be valid and contain 10-20 digits (No symbol except +).',
            'Email.string' => 'Email must be text (you can enter without @).',
            'Email.max' => 'Email cannot exceed 100 characters.',
            'Date_of_joining.date' => 'Date of Joining must be a valid date.',
            'Job_Type.string' => 'Job Type must be text.',
            'Job_Type.max' => 'Job Type cannot exceed 50 characters.',
            'Designation.string' => 'Designation must be text.',
            'Designation.max' => 'Designation cannot exceed 100 characters.',
            'Department.string' => 'Department must be text.',
            'Department.max' => 'Department cannot exceed 100 characters.',
            'Work_Location.string' => 'Work Location must be text.',
            'Work_Location.max' => 'Work Location cannot exceed 100 characters.',
            'Source_of_Funding.string' => 'Source of Funding must be text.',
            'Source_of_Funding.max' => 'Source of Funding cannot exceed 100 characters.',
            'Starting_Salary.numeric' => 'Starting Salary must be a number.',
            'Starting_Salary.min' => 'Starting Salary cannot be negative.',
            'Current_Salary.numeric' => 'Current Salary must be a number.',
            'Current_Salary.min' => 'Current Salary cannot be negative.',
            'Probation_Ending_Date.date' => 'Probation Ending Date must be a valid date.',
            'Probation_Ending_Date.after_or_equal' => 'Probation Ending Date cannot be before Date of Joining.',
            'Date_of_Leaving.date' => 'Date of Leaving must be a valid date.',
            'Date_of_Leaving.after_or_equal' => 'Date of Leaving cannot be before Date of Joining.',
            'Final_Settlement.string' => 'Final Settlement must be text only.',
            'Final_Settlement.regex' => 'Final Settlement can only contain letters and spaces.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $employee->update($validatedData);

        return redirect()->route('employees.index')
                        ->with('success', 'Employee updated successfully!');
    }


    public function updateLeaveTotals(Request $request)
    {
        // Parse JSON if sent
        $data = $request->json()->all() ?: $request->all();

        $request->merge($data);

        $leave = LeaveBalance::where('employee_id', $request->employee_id)->first();

        if (!$leave) {
            return response()->json(['success' => false, 'message' => 'Leave record not found']);
        }

        $leave->casual_total  = $request->casual_total;
        $leave->sick_total    = $request->sick_total;
        $leave->annual_total  = $request->annual_total;

        $leave->total_allocated = $leave->casual_total + $leave->sick_total + $leave->annual_total;
        $leave->total_leaves    = $leave->total_allocated;
        $leave->remaining_leaves = $leave->total_allocated - ($leave->casual_used + $leave->sick_used + $leave->annual_used);

        $leave->save();

        return response()->json(['success' => true]);
    }


    // Soft delete
    public function destroy($cnic)
    {
        $employee = Employee::where('CNIC', $cnic)->firstOrFail();
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully (soft).');
    }

    // Restore soft deleted
    public function restore($cnic)
    {
        $employee = Employee::withTrashed()->where('CNIC', $cnic)->firstOrFail();
        $employee->restore();

        return redirect()->route('employees.index')
            ->with('success', 'Employee restored successfully!');
    }

    // Permanent delete
    public function forceDelete($cnic)
    {
        $employee = Employee::withTrashed()->where('CNIC', $cnic)->firstOrFail();
        $employee->forceDelete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee permanently deleted!');
    }

    // Save changes (bulk permanent delete)
    public function saveChanges(Request $request)
    {
        $deleted = $request->input('deleted_rows', []);

        if (!empty($deleted)) {
           Employee::whereIn('CNIC', $deleted)->delete();
        }

        return redirect()->route('employees.index')
                        ->with('success', 'Employees deleted successfully.');
    }

}
