<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveHistoryController;
use App\Models\LeaveRequest;


// Welcome / Login page
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Show login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Logged out successfully');
})->name('logout');



// HR Dashboard
Route::get('/dashboard', function () {
    return view('hr_dashboard');
})->name('dashboard');

// Employee management page
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{cnic}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{cnic}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{cnic}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::post('/employees/{cnic}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::delete('/employees/{cnic}/force-delete', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete');
Route::post('/employees/save-changes', [EmployeeController::class, 'saveChanges'])->name('employees.saveChanges');

//Department
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');

Route::get('/hr/leave-dashboard', function (\Illuminate\Http\Request $request) {

    $query = LeaveRequest::query();

    if ($request->filled('leave_type')) {
        $query->where('leave_type', $request->leave_type);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('start_date', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('end_date', '<=', $request->to_date);
    }

    $leaves = $query->orderBy('start_date', 'desc')->get();

    return view('leave.history', compact('leaves'));
})->name('leave.dashboard');

Route::get('/leave/history', [LeaveController::class, 'leaveHistory'])->name('leave.history');
Route::get('/leave/balance', [LeaveController::class, 'leaveBalance'])->name('leave.balance');



Route::get('/leave/create', [LeaveController::class, 'create'])->name('leave.create');
Route::post('/leave/store', [LeaveController::class, 'store'])->name('leave.store');
Route::get('/leave-history', [LeaveHistoryController::class, 'index'])->name('leave.history.index');


// Show apply form for editing an existing leave
Route::get('leave/apply/{id}/edit', [LeaveController::class, 'editApply'])->name('leave.apply.edit');

// Update leave after editing
Route::put('leave/apply/{id}', [LeaveController::class, 'updateApply'])->name('leave.update');


Route::post('/leave/reset', [LeaveController::class, 'resetLeaves'])->name('leave.reset');

// Update total leave balances
Route::post('/leave/update-totals', [LeaveController::class, 'updateLeaveTotals'])->name('leave.update.totals');


// Reset leaves
Route::post('/leave/reset', [LeaveController::class, 'resetLeaves'])->name('leave.reset');
