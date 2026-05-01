<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management - Rahma Islamic Relief Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #42A5F5 0%, #1976D2 50%, #64B5F6 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .container {
            max-width: 1400px;
            margin: 20px 0 auto;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        h1 {
            color: #1565C0;
            font-size: 2.2rem;
            font-weight: 700;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #42A5F5 0%, #1E88E5 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(66, 165, 245, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1E88E5 0%, #0D47A1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(66, 165, 245, 0.6);
        }

        .btn-success {
            background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 187, 106, 0.4);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #43A047 0%, #2E7D32 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 187, 106, 0.6);
        }

        .btn-success:disabled {
            background: #ccc;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, #FFA726 0%, #FB8C00 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 167, 38, 0.4);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #FB8C00 0%, #EF6C00 100%);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #FFFFFF;
            color: #e11717;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        }

        .btn-danger:hover {
            background: #e11717;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .btn-info {
            background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(41, 182, 246, 0.4);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #039BE5 0%, #0277BD 100%);
            transform: translateY(-1px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #C8E6C9 0%, #A5D6A7 100%);
            color: #2E7D32;
            border-left: 4px solid #43A047;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-box input:focus {
            outline: none;
            border-color: #42A5F5;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1);
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
            color: white;
        }

        th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f5f9ff;
        }

        .table-danger {
            background: #ffebee !important;
        }

        .table-danger:hover {
            background: #ffcdd2 !important;
        }

        .action-btns {
            background: #FFFFFF;
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .action-btns button,
        .action-btns a {
            margin: 0;
        }


        /* Only Edit button (btn-warning) inside action-btns is green */
        .action-btns .btn-warning {
           background: #FFFFFF;
            color: #1EAE5D;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        }

        .action-btns .btn-warning:hover {
           background: #1EAE5D;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
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

    tbody tr.selected {
        background-color: #d0e8ff;
    }


    </style>
</head>
<body>
<!-- Back Button -->
<a href="{{ route('dashboard') }}" class="back-btn blue-back">← Back</a>

<div class="container">
    <div class="header">
    <h1>Employee Management</h1>
    <div class="btn-group">
        <!-- Add Employee button -->
        <a href="{{ route('employees.create') }}" class="btn btn-success">Add Employee</a>

        <!-- Save Changes button stays disabled until rows are deleted -->
        <button type="submit" form="employeesForm" id="saveChangesBtn" class="btn btn-success" disabled>
            Save Changes
        </button>

       <!-- Leave Application Button -->
        <button type="button" id="applyLeaveBtn" class="btn btn-success" disabled>
            Leave Application
        </button>

        <button type="button" id="printBtn" class="btn btn-success">Print</button>
        <button id="exportBtn" class="btn btn-success">Export to Excel</button>
    </div>
</div>


    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form method="GET" action="{{ route('employees.index') }}" class="search-box">
        <input type="text" name="search" placeholder="Search by Name, ID, Department, Work Location" value="{{ request('search') }}">
    </form>

    <!-- Employees Table -->
<form id="employeesForm" action="{{ route('employees.saveChanges') }}" method="POST">
    @csrf
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Emp_ID</th>
                    <th>Name</th>
                    <th>Father_name</th>
                    <th>CNIC</th>
                    <th>Qualification</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Religion</th>
                    <th>Nationality</th>
                    <th>Domicile</th>
                    <th>District</th>
                    <th>Present_Home_Address</th>
                    <th>Permanent_Home_Address</th>
                    <th>Phone_no</th>
                    <th>Email</th>
                    <th>Date_of_joining</th>
                    <th>Job_Type</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Starting_Salary</th>
                    <th>Current_Salary</th>
                    <th>Work_Location</th>
                    <th>Source_of_Funding</th>
                    <th>Date_of_Leaving</th>
                    <th>Probation_Ending_Date</th>
                    <th>Final_Settlement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr 
                    data-emp-id="{{ (string) $emp->Emp_ID }}" 
                    data-emp-name="{{ e($emp->Name) }}">
                    <td>{{ $emp->Emp_ID }}</td> 
                    <td>{{ $emp->Name }}</td>
                    <td>{{ $emp->Father_name }}</td>
                    <td>{{ $emp->CNIC }}</td>
                    <td>{{ $emp->Qualification }}</td>
                    <td>{{ $emp->Gender }}</td>

                    <!-- Safe DOB -->
                    <td>
                        @php
                            try {
                                $dob = $emp->DOB ? \Carbon\Carbon::parse($emp->DOB)->format('d/m/Y') : '';
                            } catch (\Exception $e) {
                                $dob = $emp->DOB;
                            }
                        @endphp
                        {{ $dob }}
                    </td>

                    <td>{{ $emp->Religion }}</td>
                    <td>{{ $emp->Nationality }}</td>
                    <td>{{ $emp->Domicile }}</td>
                    <td>{{ $emp->District }}</td>
                    <td>{{ $emp->Present_Home_Address }}</td>
                    <td>{{ $emp->Permanent_Home_Address }}</td>
                    <td>{{ $emp->Phone_no }}</td>
                    <td>{{ $emp->Email }}</td>
                    

                    <!-- Safe Date_of_joining -->
                    <td>
                        @php
                            try {
                                $doj = $emp->Date_of_joining ? \Carbon\Carbon::parse($emp->Date_of_joining)->format('d/m/Y') : '';
                            } catch (\Exception $e) {
                                $doj = $emp->Date_of_joining;
                            }
                        @endphp
                        {{ $doj }}
                    </td>

                    <td>{{ $emp->Job_Type }}</td>
                    <td>{{ $emp->Designation }}</td>
                    <td>{{ $emp->Department }}</td>
                    <td>{{ $emp->Starting_Salary }}</td>
                    <td>{{ $emp->Current_Salary }}</td>
                    <td>{{ $emp->Work_Location }}</td>
                    <td>{{ $emp->Source_of_Funding }}</td>

                    <!-- Safe Date_of_Leaving -->
                    <td>
                        @php
                            try {
                                $dol = $emp->Date_of_Leaving ? \Carbon\Carbon::parse($emp->Date_of_Leaving)->format('d/m/Y') : '';
                            } catch (\Exception $e) {
                                $dol = $emp->Date_of_Leaving;
                            }
                        @endphp
                        {{ $dol }}
                    </td>

                    <!-- Safe Probation_Ending_Date -->
                    <td>
                        @php
                            try {
                                $ped = $emp->Probation_Ending_Date ? \Carbon\Carbon::parse($emp->Probation_Ending_Date)->format('d/m/Y') : '';
                            } catch (\Exception $e) {
                                $ped = $emp->Probation_Ending_Date;
                            }
                        @endphp
                        {{ $ped }}
                    </td>

                    <td>{{ $emp->Final_Settlement }}</td>

                    <td class="action-btns">
                        <a href="{{ route('employees.edit', $emp->CNIC) }}" class="btn btn-warning">
                            Edit
                        </a>
                        <button type="button" class="btn btn-danger delete-btn">Delete</button>
                        <button type="button" class="btn btn-info restore-btn" style="display:none;">Restore</button>

                        <!-- Hidden input -->
                        <input type="hidden" name="deleted_rows[]" value="{{ $emp->CNIC }}" class="deleted-flag" disabled>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="28" style="text-align:center; padding:20px; font-weight:600; color:#555;">
                        No employees found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const applyLeaveBtn = document.getElementById('applyLeaveBtn');
    const rows = document.querySelectorAll('tbody tr');

    let selectedEmpId = null;
    let selectedEmpName = null;

    rows.forEach(row => {

        // Skip "No employees found" row
        if (row.querySelector('td')?.colSpan == 28) return;

        row.addEventListener('click', function (e) {

            // Ignore clicks on action buttons
            if (e.target.closest('a, button')) return;

            rows.forEach(r => r.classList.remove('selected'));
            row.classList.add('selected');

            selectedEmpId = row.dataset.empId;
            selectedEmpName = row.dataset.empName;

            console.log('Selected:', selectedEmpId, selectedEmpName); // DEBUG

            applyLeaveBtn.disabled = false;
        });
    });

    applyLeaveBtn.addEventListener('click', function () {

        if (!selectedEmpId || !selectedEmpName) {
            alert('Please select an employee first');
            return;
        }

        const url =
            `/leave/create?employee_id=${selectedEmpId}&employee_name=${encodeURIComponent(selectedEmpName)}`;

        console.log('Redirecting:', url); // DEBUG
        window.location.href = url;
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const saveChangesBtn = document.getElementById('saveChangesBtn');

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const deletedFlag = row.querySelector('.deleted-flag');

            this.style.display = 'none';
            row.querySelector('.restore-btn').style.display = 'inline-block';

            deletedFlag.disabled = false;
            row.classList.add('table-danger');

            saveChangesBtn.disabled = false;
        });
    });

    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const deletedFlag = row.querySelector('.deleted-flag');

            this.style.display = 'none';
            row.querySelector('.delete-btn').style.display = 'inline-block';

            deletedFlag.disabled = true;
            row.classList.remove('table-danger');

            const anyDeleted = Array.from(document.querySelectorAll('.deleted-flag'))
                .some(input => !input.disabled);

            saveChangesBtn.disabled = !anyDeleted;
        });
    });
});

    // Handle restore buttons
    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const deletedFlag = row.querySelector('.deleted-flag');

            // Hide Restore button, show Delete button
            this.style.display = 'none';
            row.querySelector('.delete-btn').style.display = 'inline-block';

            // Unmark row as deleted
            deletedFlag.value = '';

            // Remove deleted styling
            row.classList.remove('table-danger');

            // Disable Save Changes if no rows are deleted
            const anyDeleted = Array.from(document.querySelectorAll('.deleted-flag'))
                                    .some(input => input.value !== '');
            saveChangesBtn.disabled = !anyDeleted;
        });
    });

//print functionality
document.getElementById('printBtn').addEventListener('click', function() {
    // Get the table wrapper
    let tableWrapper = document.querySelector('.table-wrapper');

    // Open a new window for printing
    let newWin = window.open('', 'Print-Window');

    newWin.document.open();
    newWin.document.write(`
        <html>
        <head>
            <title>Employee List</title>
            <style>
                body { font-family: 'Poppins', sans-serif; padding: 20px; color: #000; }
                h2 { text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 10px; text-align: left; font-size: 0.9rem; }
                th { background: #1565C0; color: white; }
                tbody tr:nth-child(even) { background: #f2f2f2; }
                
            </style>
        </head>
        <body>
            <h2>Employee List</h2>
            ${tableWrapper.querySelector('table').outerHTML}
        </body>
        </html>
    `);
    newWin.document.close();

    newWin.focus();
    newWin.print();
    newWin.close();
});
</script>


<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


<script>
document.getElementById('exportBtn').addEventListener('click', function() {
    // Get table
    let table = document.querySelector('table');

    // Convert table to workbook
    let wb = XLSX.utils.table_to_book(table, { sheet: "Employees" });

    // Export to Excel
    XLSX.writeFile(wb, "employees.xlsx");
});
</script>

<!-- Birthday Notification -->
@php
    use Carbon\Carbon;
    $today = Carbon::today();
    $birthdayEmployees = [];
    
    foreach($employees as $emp) {
        if ($emp->Work_Location === 'Head Office' && $emp->DOB) {
            try {
                $dob = Carbon::parse($emp->DOB);
                if ($dob->format('m-d') === $today->format('m-d')) {
                    $birthdayEmployees[] = $emp->Name;
                }
            } catch (\Exception $e) {
                // Skip invalid dates
            }
        }
    }
@endphp

@if(count($birthdayEmployees) > 0)
<div id="birthdayNotification" style="
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: linear-gradient(135deg, #FF6B6B 0%, #FFD93D 25%, #6BCF7F 50%, #4D96FF 75%, #9B59B6 100%);
    padding: 40px 50px;
    border-radius: 25px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    z-index: 10000;
    text-align: center;
    animation: slideIn 0.5s ease-out;
    border: 5px solid white;
    display: none;
">
    <div style="font-size: 3rem; margin-bottom: 15px;">🎉🎂🎈</div>
    <h2 style="color: white; font-size: 2rem; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
        Birthday Alert!
    </h2>
    <p style="color: white; font-size: 1.3rem; margin-bottom: 10px; font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
        @if(count($birthdayEmployees) === 1)
            It's {{ $birthdayEmployees[0] }}'s birthday today!
        @else
            It's {{ implode(', ', array_slice($birthdayEmployees, 0, -1)) }} and {{ end($birthdayEmployees) }}'s birthdays today!
        @endif
    </p>
    
    <div style="margin-top: 20px; margin-bottom: 15px;">
        <label style="color: white; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <input type="checkbox" id="doNotShowAgain" style="width: 18px; height: 18px; cursor: pointer;">
            <span>Do not show again today</span>
        </label>
    </div>
    
    <button onclick="closeBirthdayNotification()" style="
        margin-top: 5px;
        padding: 12px 30px;
        background: white;
        color: #FF6B6B;
        border: none;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    " onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
        Got it!
    </button>
    
    <!-- Sparkles Animation -->
    <div class="sparkles"></div>
</div>

<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
    50% { opacity: 1; transform: scale(1) rotate(180deg); }
}

.sparkles::before,
.sparkles::after {
    content: '✨';
    position: absolute;
    font-size: 2rem;
    animation: sparkle 2s infinite;
}

.sparkles::before {
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.sparkles::after {
    top: 15%;
    right: 15%;
    animation-delay: 0.5s;
}

#birthdayNotification::before {
    content: '🎊';
    position: absolute;
    top: -20px;
    left: 20px;
    font-size: 3rem;
    animation: sparkle 1.5s infinite;
}

#birthdayNotification::after {
    content: '🎁';
    position: absolute;
    bottom: -20px;
    right: 20px;
    font-size: 3rem;
    animation: sparkle 1.5s infinite 0.7s;
}
</style>

<script>
(function() {
    const today = new Date().toDateString();
    const hiddenKey = 'birthdayHidden_' + today;
    
    // Check if user chose to hide notification for today
    if (!localStorage.getItem(hiddenKey)) {
        const notification = document.getElementById('birthdayNotification');
        if (notification) {
            notification.style.display = 'block';
        }
    }
})();

function closeBirthdayNotification() {
    const notification = document.getElementById('birthdayNotification');
    const checkbox = document.getElementById('doNotShowAgain');
    const today = new Date().toDateString();
    const hiddenKey = 'birthdayHidden_' + today;
    
    if (notification) {
        notification.style.display = 'none';
    }
    
    // If checkbox is checked, save preference for today
    if (checkbox && checkbox.checked) {
        localStorage.setItem(hiddenKey, 'true');
    }
}
</script>
@endif
</body>
</html>
