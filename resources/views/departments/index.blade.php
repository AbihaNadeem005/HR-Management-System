<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Department - Employee List</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #42A5F5 0%, #1976D2 50%, #64B5F6 100%); min-height:100vh; padding:30px 20px; }
.container { max-width:1400px; margin:20px 0 auto; background: rgba(255,255,255,0.98); border-radius:20px; padding:40px; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
h1 { color:#1565C0; font-size:2.2rem; font-weight:700; margin-bottom:20px; }
.search-box { margin-bottom:25px; }
.search-box input { width:100%; padding:15px 20px; border:2px solid #e0e0e0; border-radius:12px; font-size:1rem; transition: all 0.3s ease; }
.search-box input:focus { outline:none; border-color:#42A5F5; box-shadow:0 0 0 3px rgba(66,165,245,0.1); }
.salary-cards { display:flex; gap:20px; margin-bottom:30px; flex-wrap:wrap; }
.card { flex:1 1 200px; padding:20px; border-radius:12px; background:white; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center; }
.card strong { font-size:1rem; color:#0D47A1; }
.table-wrapper { overflow-x:auto; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
table { width:100%; border-collapse:collapse; background:white; }
thead { background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%); color:white; }
th, td { padding:12px; font-size:0.9rem; white-space:nowrap; text-align:left; }
th { position:sticky; top:0; z-index:10; }
tbody tr { transition: background 0.2s ease; }
tbody tr:hover { background:#f5f9ff; }
.action-btns { display:flex; gap:5px; flex-wrap:wrap; }
.btn { padding:8px 16px; border:none; border-radius:12px; font-size:0.9rem; font-weight:600; cursor:pointer; color:white; text-decoration:none; transition:all 0.3s ease; }
.btn-edit { background: #FFFFFF;
            color: #1EAE5D;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25); }
            
.btn-edit:hover { background: #1EAE5D;
            color: #FFFFFF;
            transform: translateY(-2px); }

.btn-info { background: linear-gradient(135deg, #29B6F6 0%, #039BE5 100%); }
.btn-info:hover { background: linear-gradient(135deg, #039BE5 0%, #0277BD 100%); }

/*ADDED: Success button */
.btn-success {
    background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%);
}
.btn-success:hover {
    background: linear-gradient(135deg, #43A047 0%, #2E7D32 100%);
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

<a href="{{ route('dashboard') }}" class="back-btn blue-back">← Back</a>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap;">
        <h1 style="margin:0;">Department - Employee List</h1>
        <div class="header-actions">
            <button id="printBtn" class="btn btn-success">Print</button>
            <button id="exportBtn" class="btn btn-success">Export to Excel</button>
        </div>
    </div>

    <form method="GET" action="{{ route('departments.index') }}" class="search-box">
        <input type="text" name="search" placeholder="Search by Name, ID, Department or Work Location" value="{{ $search ?? '' }}">
    </form>

    <div class="salary-cards">
        <div class="card">
            <strong>Highest Salary:</strong><br> @if($highest) Rs. {{ number_format($highest->Current_Salary) }} – {{ $highest->Name }} @else N/A @endif
        </div>
        <div class="card">
            <strong>Lowest Salary:</strong><br> @if($lowest) Rs. {{ number_format($lowest->Current_Salary) }} – {{ $lowest->Name }} @else N/A @endif
        </div>
        <div class="card">
            <strong>Average Salary:</strong><br> Rs. {{ number_format($average) }}
        </div>
        <div class="card">
            <strong>Total Department Cost:</strong><br> Rs. {{ number_format($total) }}
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Work Location</th>
                    <th>Job Type</th>
                    <th>Current Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($employees as $employee)
            @if(!empty($employee->Emp_ID) && $employee->Emp_ID != 'Emp_ID')
                <tr>
                    <td>{{ $employee->Emp_ID }}</td>
                    <td>{{ $employee->Name }}</td>
                    <td>{{ $employee->Designation }}</td>
                    <td>{{ $employee->Department }}</td>
                    <td>{{ $employee->Work_Location }}</td>
                    <td>{{ $employee->Job_Type }}</td>
                    <td>Rs. {{ number_format($employee->Current_Salary) }}</td>
                    <td>
                    <a href="{{ route('employees.edit', ['cnic' => $employee->CNIC]) }}" class="btn btn-edit">Edit</a>

                    </td>
                </tr>
            @endif
            @empty
            <tr>
                <td colspan="8" style="text-align:center; color:#666; font-weight:600;">No matches found</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('printBtn').addEventListener('click', function () {
    let tableWrapper = document.querySelector('.table-wrapper');
    let newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write(`
    <html>
    <head>
    <title>Employee List</title>
    <style>
    body { font-family: Poppins, sans-serif; padding: 20px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #000; padding:10px; }
    th { background:#1565C0; color:white; }
    </style>
    </head>
    <body>
    <h2>Department - Employee List</h2>
    ${tableWrapper.querySelector('table').outerHTML}
    </body>
    </html>
    `);
    newWin.document.close();
    newWin.print();
    newWin.close();
});
</script>

<!-- ADDED: XLSX library (required for Excel export) -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
document.getElementById('exportBtn').addEventListener('click', function() {
    let table = document.querySelector('.table-wrapper table');
    let wb = XLSX.utils.table_to_book(table, { sheet: "Employees" });
    XLSX.writeFile(wb, "department_employees.xlsx");
});
</script>

</body>
</html>
