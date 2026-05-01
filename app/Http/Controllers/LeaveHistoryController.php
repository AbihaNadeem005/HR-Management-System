<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;

class LeaveHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::query();

        // Filter by leave type
        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        // Filter by start date
        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        // Filter by end date
        if ($request->filled('to_date')) {
            $query->whereDate('end_date', '<=', $request->to_date);
        }

        $leaveHistory = $query->orderBy('start_date', 'desc')->get();

        return view('leave-history', compact('leaveHistory'));
    }
}
