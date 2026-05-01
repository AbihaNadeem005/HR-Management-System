<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leave History - Rahma Islamic Relief Center</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* { margin:0; padding:0; box-sizing: border-box; }

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #42A5F5 0%, #1976D2 50%, #64B5F6 100%);
    min-height: 100vh;
    padding: 30px 20px;
}

/* HAMBURGER CONTAINER */
.hamburger-container {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1000;
}

/* Stylish Hamburger Button */
.hamburger {
    width: 50px;
    height: 50px;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}

/* Hamburger lines */
.hamburger span {
    position: absolute;
    width: 22px;
    height: 2px;
    background: white;
    border-radius: 2px;
    transition: 0.3s ease;
}

.hamburger span:nth-child(1) {
    transform: translateY(-6px);
}

.hamburger span:nth-child(2) {
    transform: translateY(0);
}

.hamburger span:nth-child(3) {
    transform: translateY(6px);
}

/* Hover effect */
.hamburger:hover {
    transform: translateY(-3px) scale(1.05);
    background: linear-gradient(135deg, #6DBE45, #1E88D9);
}


/* DROPDOWN MENU */
.dropdown-menu {
    display: none;
    position: absolute;
    top: 60px; /* little lower for better spacing */
    left: 0;
    min-width: 180px;

    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    padding: 10px 0;

    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    border: 1px solid rgba(255,255,255,0.3);

    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

/* Show animation */
.dropdown-menu.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Links */
.dropdown-menu a {
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Hover effect */
.dropdown-menu a:hover {
    background: rgba(255,255,255,0.2);
    padding-left: 25px;
}

/* MAIN CONTAINER */
.container {
    max-width: 1100px;
    margin: 0 auto;
    background: rgba(255,255,255,0.98);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.header { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0; }
h1 { color: #1565C0; font-size: 2.2rem; font-weight: 700; margin-bottom: 5px; }
.subtitle { color: #666; font-size: 1rem; }
.section-title { color: #1565C0; font-size: 1.3rem; font-weight: 600; margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0; }

/* FILTER BAR */
.search-bar {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 25px;
}

.search-bar select,
.search-bar input[type="date"] {
    padding: 12px 16px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    font-size: 0.95rem;
}

.search-bar button {
    grid-column: span 4;
    padding: 14px;
    border-radius: 25px;
    border: none;
    background: linear-gradient(135deg, #66BB6A 0%, #43A047 100%);
    color: white;
    font-weight: 600;
    cursor: pointer;
}

/* TABLE */
.table-wrapper { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
table th { background: #1565C0; color: white; padding: 14px; font-weight: 600; text-align: center; }
table td { padding: 12px; text-align: center; border-bottom: 1px solid #e0e0e0; }
tbody tr:nth-child(even) { background-color: #f5f7fa; }
tbody tr:hover { background-color: #e3f2fd; }
.no-data { padding: 20px; font-weight: 500; color: #555; }

/* EDIT BUTTON */
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
</style>
</head>
<body>

<!-- HAMBURGER -->
<div class="hamburger-container">
    <div class="hamburger" onclick="toggleDropdown()">☰</div>
    <div class="dropdown-menu" id="dropdownMenu">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <a href="{{ route('leave.balance') }}">Leave Balance</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container">
    <div class="header">
        <h1>Leave History</h1>
        <p class="subtitle">View and filter employee leave records</p>
    </div>

    <div class="section-title">Search Filters</div>
    <form method="GET" action="{{ route('leave.dashboard') }}" class="search-bar">
        <select name="leave_type">
            <option value="">All Leave Types</option>
            <option value="Casual leave" {{ request('leave_type') == 'Casual leave' ? 'selected' : '' }}>Casual leave</option>
            <option value="Sick leave" {{ request('leave_type') == 'Sick leave' ? 'selected' : '' }}>Sick leave</option>
            <option value="Annual leave" {{ request('leave_type') == 'Annual leave' ? 'selected' : '' }}>Annual leave</option>
        </select>
        <input type="date" name="from_date" value="{{ request('from_date') }}">
        <input type="date" name="to_date" value="{{ request('to_date') }}">
        <button type="submit">Search Leave History</button>
    </form>

    <div class="section-title">Results</div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td>{{ $leave->employee_id }}</td>
                    <td>{{ $leave->employee_name }}</td>
                    <td>{{ $leave->leave_type }}</td>
                    <td>{{ $leave->start_date }}</td>
                    <td>{{ $leave->end_date }}</td>
                    <td>{{ $leave->status }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        <a href="{{ route('leave.apply.edit', $leave->id) }}" class="btn-edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="no-data">No leave history found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

// Close dropdown if clicked outside
window.onclick = function(event) {
    if (!event.target.matches('.hamburger')) {
        const dropdown = document.getElementById('dropdownMenu');
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    }
}

    const hamburger = document.querySelector('.hamburger');
    const dropdown = document.querySelector('.dropdown-menu');

    hamburger.addEventListener('click', function() {
        dropdown.classList.toggle('show');
    });

    // Optional: close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!hamburger.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

</script>

</body>
</html>
