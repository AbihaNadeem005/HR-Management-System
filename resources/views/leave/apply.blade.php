<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leave Application - Rahma Islamic Relief Center</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #42A5F5 0%, #1976D2 50%, #64B5F6 100%);
    min-height: 100vh;
    padding: 30px 20px;
}
.container {
    max-width: 900px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.98);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}
.header { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0; }
h1 { color: #1565C0; font-size: 2.2rem; font-weight: 700; margin-bottom: 10px; }
.subtitle { color: #666; font-size: 1rem; font-weight: 400; }
.section-title { color: #1565C0; font-size: 1.3rem; font-weight: 600; margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0; }
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
.form-group { display: flex; flex-direction: column; }
.form-group.full-width { grid-column: 1 / -1; }
label { font-weight: 600; color: #333; margin-bottom: 8px; font-size: 0.95rem; }
input[type="text"], input[type="date"], textarea, select {
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
    background: white;
}
input:focus, select:focus, textarea:focus { outline: none; border-color: #42A5F5; box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1); }
input[readonly] { background: #f5f5f5; color: #666; cursor: not-allowed; }
textarea { resize: none; height: 80px; }
.radio-group { display: flex; gap: 15px; align-items: center; }
.radio-group label { display: flex; align-items: center; font-weight: 500; color: #333; }
.radio-group input[type="radio"] { margin-right: 5px; }
.btn-group { display: flex; gap: 15px; justify-content: flex-start; }
.btn { padding: 14px 32px; border: none; border-radius: 25px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block; }
.btn-success { background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%); color: white; box-shadow: 0 4px 15px rgba(102, 187, 106, 0.4); }
.btn-success:hover { background: linear-gradient(135deg, #43A047 0%, #2E7D32 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 187, 106, 0.6); }
.btn-secondary { background: linear-gradient(135deg, #78909C 0%, #546E7A 100%); color: white; box-shadow: 0 4px 15px rgba(120, 144, 156, 0.4); }
.btn-secondary:hover { background: linear-gradient(135deg, #546E7A 0%, #37474F 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(120, 144, 156, 0.6); }
.flash-message { padding: 15px 20px; background-color: #4CAF50; color: white; margin-bottom: 20px; border-radius: 10px; font-weight: 600; }
.error-message { color: red; font-size: 0.9rem; margin-top: 5px; }
@media (max-width: 768px) {
    .form-grid { grid-template-columns: 1fr; }
    .btn-group { flex-direction: column; }
    .btn { width: 100%; text-align: center; }
}
.back-btn {
            background: #FFFFFF;
            color: #1EAE5D;
            font-weight: 600;
            border: none;
            padding: 10px 22px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }

    .back-btn:hover {
            background: #1EAE5D;
            color: #FFFFFF;
            transform: translateY(-2px);
    }
</style>
</head>
<body>

<a href="{{ route('employees.index') }}" class="back-btn">← Back</a>

<div class="container">
    <div class="header">
        <h1>{{ isset($leave) ? 'Edit Leave Application' : 'Leave Application' }}</h1>
        <p class="subtitle">Fill in the details below</p>
    </div>

    <!-- FLASH MESSAGE -->
    @if(session('success'))
        <div class="flash-message">{{ session('success') }}</div>
    @endif

    @if(isset($leave))
        <form method="POST" action="{{ route('leave.update', $leave->id) }}">
        @method('PUT')
    @else
        <form method="POST" action="{{ route('leave.store') }}">
    @endif
    @csrf

    <div class="section-title">Employee Information</div>
    <div class="form-grid">
        <div class="form-group">
            <label>Employee ID</label>
            <input type="text" name="employee_id" readonly
                value="{{ $leave->employee_id ?? old('employee_id', $employeeId) }}">
            @error('employee_id') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Employee Name</label>
            <input type="text" name="employee_name" readonly
                value="{{ $leave->employee_name ?? old('employee_name', $employeeName) }}">
            @error('employee_name') <div class="error-message">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="section-title">Leave Details</div>
    <div class="form-grid">
        <div class="form-group">
            <label>Leave Type</label>
            <select name="leave_type" required>
                <option value="" disabled {{ isset($leave) ? '' : 'selected' }}>Select leave type</option>
                @foreach($leave_types as $type)
                    <option value="{{ $type->name }}"
                        {{ (isset($leave) && $leave->leave_type == $type->name) || old('leave_type') == $type->name ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('leave_type') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>From Date</label>
            <input type="date" name="start_date" value="{{ $leave->start_date ?? old('start_date') }}">
            @error('start_date') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>To Date</label>
            <input type="date" name="end_date" value="{{ $leave->end_date ?? old('end_date') }}">
            @error('end_date') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group full-width">
            <label>Reason (optional)</label>
            <textarea name="reason">{{ $leave->reason ?? old('reason') }}</textarea>
            @error('reason') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group full-width">
            <label>Leave Status</label>
            <div class="radio-group">
                <label><input type="radio" name="status" value="Pending" 
                    {{ (isset($leave) && $leave->status == 'Pending') || old('status', 'Pending') == 'Pending' ? 'checked' : '' }}> Pending</label>
                <label><input type="radio" name="status" value="Approved" 
                    {{ (isset($leave) && $leave->status == 'Approved') || old('status') == 'Approved' ? 'checked' : '' }}> Approved</label>
                <label><input type="radio" name="status" value="Rejected" 
                    {{ (isset($leave) && $leave->status == 'Rejected') || old('status') == 'Rejected' ? 'checked' : '' }}> Rejected</label>
            </div>
            @error('status') <div class="error-message">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-success">
            {{ isset($leave) ? 'Update Leave' : 'Submit Leave' }}
        </button>
        <a href="{{ route('leave.history') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
</div>
</body>
</html>
