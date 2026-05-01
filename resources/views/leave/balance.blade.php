<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Leave Balance</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #42A5F5 0%, #1976D2 50%, #64B5F6 100%); min-height:100vh; padding:30px 20px; }
.container { max-width:1400px; margin:20px 0 auto; background: rgba(255,255,255,0.98); border-radius:20px; padding:40px; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
h1 { color:#1565C0; font-size:2.2rem; font-weight:700; margin-bottom:20px; }
.table-wrapper { overflow-x:auto; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
table { width:100%; border-collapse:collapse; background:white; }
thead { background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%); color:white; }
th, td { padding:12px; font-size:0.9rem; white-space:nowrap; text-align:left; }
th { position:sticky; top:0; z-index:10; }
tbody tr { transition: background 0.2s ease; }
tbody tr:hover { background:#f5f9ff; }
.btn { padding:8px 16px; border:none; border-radius:12px; font-size:0.9rem; font-weight:600; cursor:pointer; color:white; text-decoration:none; transition:all 0.3s ease; }
.btn-info { background: linear-gradient(135deg, #66BB6A 0%, #66BB6A 100%); }
.btn-info:hover { background: linear-gradient(135deg, #66BB6A 0%, #66BB6A 100%); }
.btn-success { background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%); }
.btn-success:hover { background: linear-gradient(135deg, #43A047 0%, #2E7D32 100%); }
.btn-reset { background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); }
.btn-reset:hover { background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); }
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
.btn-graph { background: #FFFFFF;
            color: #1EAE5D;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25); }
            
.btn-graph:hover { background: #1EAE5D;
            color: #FFFFFF;
            transform: translateY(-2px); }
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
.over-limit {
    background-color: #f8d7da !important;
}
.search-box { margin-bottom:25px; }
.search-box input { width:100%; padding:15px 20px; border:2px solid #e0e0e0; border-radius:12px; font-size:1rem; transition: all 0.3s ease; }
.search-box input:focus { outline:none; border-color:#42A5F5; box-shadow:0 0 0 3px rgba(66,165,245,0.1); }
.header-actions .btn {
    margin-left: 10px; 
}

</style>
</head>
<body>

<a href="{{ route('dashboard') }}" class="back-btn">← Back</a>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap;">
        <h1>Employee Leave Balance</h1>
        <div class="header-actions">
            <a href="{{ route('leave.balance', ['show_all' => !($showAll ?? false), 'search' => $search ?? '']) }}" 
            class="btn btn-success" >
                {{ ($showAll ?? false) ? 'Head Office Only' : 'Show All' }}
            </a>
            <button id="printBtn" class="btn btn-success">Print</button>
            <button id="exportBtn" class="btn btn-success">Export to Excel</button>
            <button id="resetBtn" class="btn btn-reset">Reset Leaves</button>
        </div>
    </div>
    <form method="GET" action="{{ route('leave.balance') }}" class="search-box">
        <input type="text" name="search" placeholder="Search by Name or ID" value="{{ $search ?? '' }}">
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Total Leaves</th>
                    <th>Used Leaves</th>
                    <th>Remaining Leaves</th>
                    <th>Casual Leave</th>
                    <th>Sick Leave</th>
                    <th>Annual Leave</th>
                    <th>Work_Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr class="{{ $leave->used_leaves > $leave->total_leaves ? 'over-limit' : '' }}">
                    <td>{{ $leave->Emp_ID }}</td>
                    <td>{{ $leave->Name }}</td>
                    <td>{{ $leave->total_leaves }}</td>
                    <td>{{ $leave->used_leaves }}</td>
                    <td>{{ $leave->remaining_leaves }}</td>
                    <td>{{ $leave->casual_used }}/{{ $leave->casual_total }} (R = {{ $leave->casual_remaining }})</td>
                    <td>{{ $leave->sick_used }}/{{ $leave->sick_total }} (R = {{ $leave->sick_remaining }})</td>
                    <td>{{ $leave->annual_used }}/{{ $leave->annual_total }} (R = {{ $leave->annual_remaining }})</td>
                    <td>{{ $leave->Work_Location }}</td>
                    <td>
                        <button class="btn btn-edit"
                            data-id="{{ $leave->Emp_ID }}"
                            data-casual="{{ $leave->casual_total }}"
                            data-sick="{{ $leave->sick_total }}"
                            data-annual="{{ $leave->annual_total }}">
                            Edit
                        </button>
                        <button class="btn btn-graph"
                            data-name="{{ $leave->Name }}"
                            data-total="{{ $leave->total_leaves }}"
                            data-used="{{ $leave->used_leaves }}"
                            data-remaining="{{ $leave->remaining_leaves }}">
                            Graph
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">No leave records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:1000;">
    <div style="background:white; padding:30px; border-radius:15px; width:400px; position:relative;">
        <h3>Edit Total Leaves</h3>
        <form id="editForm">
            @csrf
            <input type="hidden" id="editEmpID" name="employee_id">
            <div style="margin-bottom:10px;">
                <label>Casual Leave:</label>
                <input type="number" id="editCasual" name="casual_total" min="0" style="width:100%; padding:8px;">
            </div>
            <div style="margin-bottom:10px;">
                <label>Sick Leave:</label>
                <input type="number" id="editSick" name="sick_total" min="0" style="width:100%; padding:8px;">
            </div>
            <div style="margin-bottom:10px;">
                <label>Annual Leave:</label>
                <input type="number" id="editAnnual" name="annual_total" min="0" style="width:100%; padding:8px;">
            </div>
            <button type="submit" class="btn btn-success" style="width:100%;">Save Changes</button>
            <button type="button" id="closeModal" class="btn btn-reset" style="width:100%; margin-top:10px;">Cancel</button>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('editModal');
const editForm = document.getElementById('editForm');

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('editEmpID').value = btn.dataset.id;
        document.getElementById('editCasual').value = btn.dataset.casual;
        document.getElementById('editSick').value = btn.dataset.sick;
        document.getElementById('editAnnual').value = btn.dataset.annual;
        modal.style.display = 'flex';
    });
});

document.getElementById('closeModal').addEventListener('click', () => {
    modal.style.display = 'none';
});

editForm.addEventListener('submit', function(e){
    e.preventDefault();

    fetch("{{ route('leave.update.totals') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            employee_id: document.getElementById('editEmpID').value,
            casual_total: parseInt(document.getElementById('editCasual').value) || 0,
            sick_total: parseInt(document.getElementById('editSick').value) || 0,
            annual_total: parseInt(document.getElementById('editAnnual').value) || 0
        })
    })
    .then(res => res.json())
    .then(res => {
        if(res.success){
            alert('Total leaves updated successfully!');
            modal.style.display = 'none';
            location.reload();
        } else {
            alert('Failed to update leaves: ' + (res.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('An error occurred while updating leaves');
    });
});
// Print functionality
document.getElementById('printBtn').addEventListener('click', () => {
    const tableHtml = document.querySelector('.table-wrapper').innerHTML;
    const newWindow = window.open('', '', 'width=1000,height=600');
    newWindow.document.write('<html><head><title>Print Leave Balance</title>');
    newWindow.document.write('<style>table {width:100%;border-collapse:collapse;} th, td {padding:8px;border:1px solid #333;text-align:left;} th {background:#1565C0;color:white;} </style>');
    newWindow.document.write('</head><body>');
    newWindow.document.write(tableHtml);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
});

// Export to Excel functionality
document.getElementById('exportBtn').addEventListener('click', () => {
    let table = document.querySelector('table');
    let html = table.outerHTML.replace(/ /g, '%20');

    const filename = 'leave_balance.xls';
    const dataType = 'application/vnd.ms-excel';
    const link = document.createElement('a');

    link.href = 'data:' + dataType + ', ' + html;
    link.download = filename;
    link.click();
});

</script>
<!-- Custom Confirmation Modal (only once) -->
<div id="deleteConfirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.7); justify-content:center; align-items:center; z-index:1000;">
    <div style="background:white; padding:40px; border-radius:15px; width:500px; max-width:90%; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <h2 style="color:red; font-size:2rem; margin-bottom:20px;">⚠ Warning!</h2>
        <p style="font-size:1.3rem; margin-bottom:30px;">
            Make sure to <strong>export the data first</strong> because it will be <strong>permanently deleted</strong>.
        </p>
        <button id="confirmDelete" class="btn btn-reset" style="width:45%; margin-right:10px; font-size:1.1rem;">Yes, Delete</button>
        <button id="cancelDelete" class="btn btn-secondary" style="width:45%; font-size:1.1rem;">Cancel</button>
    </div>
</div>

<!-- Graph Modal -->
<div id="graphModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:2000;">
    <div style="background:white; padding:30px; border-radius:15px; width:500px; position:relative;">
        <h3 id="graphTitle" style="margin-bottom:15px;"></h3>
        <canvas id="leaveChart"></canvas>
        <button id="closeGraph" class="btn btn-reset" style="width:100%; margin-top:15px;">Close</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chartInstance = null;

document.querySelectorAll('.btn-graph').forEach(btn => {
    btn.addEventListener('click', () => {
        const name = btn.dataset.name;
        const total = btn.dataset.total;
        const used = btn.dataset.used;
        const remaining = btn.dataset.remaining;

        document.getElementById('graphTitle').innerText =
            `Leave Summary for ${name}`;

        const ctx = document.getElementById('leaveChart').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Leaves', 'Used Leaves', 'Remaining Leaves'],
                datasets: [{
                    label: 'Leaves',
                    data: [total, used, remaining],
                    backgroundColor: [
                        '#42A5F5',
                        '#EF5350',
                        '#66BB6A'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.getElementById('graphModal').style.display = 'flex';
    });
});

document.getElementById('closeGraph').addEventListener('click', () => {
    document.getElementById('graphModal').style.display = 'none';
});
</script>



<script>
// Reset Leaves functionality using custom modal
const resetBtn = document.getElementById('resetBtn');
const deleteModal = document.getElementById('deleteConfirmModal');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete = document.getElementById('cancelDelete');

resetBtn.addEventListener('click', () => {
    deleteModal.style.display = 'flex'; // Show large modal
});

cancelDelete.addEventListener('click', () => {
    deleteModal.style.display = 'none'; // Hide modal
});

confirmDelete.addEventListener('click', () => {
    deleteModal.style.display = 'none';

    // Perform the reset action
    fetch("{{ route('leave.reset') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(res => {
        if(res.success){
            alert('✅ All leave records have been reset!');
            location.reload();
        } else {
            alert('❌ Failed to reset leaves.');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('⚠ An error occurred while resetting leaves.');
    });
});
</script>

</body>
</html>
