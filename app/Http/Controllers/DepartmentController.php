<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        // Get the search input
        $search = $request->input('search');

        // Build the query for employees
        $query = DB::table('rwd as e')
            ->select(
                'e.Emp_ID',
                'e.Name',
                'e.CNIC', 
                'e.Job_Type',
                'e.Designation',
                'e.Department',
                'e.Current_Salary',
                'e.Work_Location'
            );

        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('e.Department', 'like', $search . '%')
                 ->orWhere('e.Name', 'like', $search . '%')
                ->orWhere('e.Emp_ID', 'like', $search . '%')
                ->orWhere('e.Work_Location', 'like', $search . '%');

            });
        }

        // Get the employees as a Collection
        $employees = $query->get();

        // Convert Current_Salary to float for stats
        $employees = $employees->map(function($emp) {
            $emp->Current_Salary = floatval(str_replace(',', '', $emp->Current_Salary));
            return $emp;
        });

        // Calculate salary stats
        if ($employees->count() > 0) {
            $highest = $employees->sortByDesc('Current_Salary')->first();
            $lowest  = $employees->sortBy('Current_Salary')->first();
            $average = round($employees->avg('Current_Salary'));
            $total   = $employees->sum('Current_Salary');
        } else {
            $highest = $lowest = null;
            $average = $total = 0;
        }

        // Pass data to view
        return view('departments.index', compact('employees', 'highest', 'lowest', 'average', 'total', 'search'));
    }
}
