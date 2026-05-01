<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; min-height: 100vh; overflow-x: hidden; background: linear-gradient(135deg, #1E88D9 0%, #0B5FA5 50%, #6DBE45 100%); display: flex; justify-content: center; align-items: center; }

        .dashboard {
            width: 100%;
            max-width: 1100px;
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
        }

        .dashboard h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .dashboard p {
            font-size: 1.2rem;
            margin-bottom: 50px;
            font-weight: 300;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1200px;
            margin-bottom: 50px;
            gap: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            width: 30%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-decoration: none; /* no underline */
            color: white;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }

        .card h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Logout button like back/cta button */
        .logout-btn {
            background: #FFFFFF;
            color: #1EAE5D;
            font-weight: 600;
            border: none;
            padding: 12px 35px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            font-size: 1rem;
        }

        .logout-btn:hover {
            background: #1EAE5D;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .logout-form {
            margin-top: 40px;
            text-align: center;
        }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0% { box-shadow: 0 10px 30px rgba(0,0,0,0.2); } 50% { box-shadow: 0 10px 30px rgba(0,0,0,0.4); } 100% { box-shadow: 0 10px 30px rgba(0,0,0,0.2); } }

        @media (max-width: 768px) {
            .dashboard h1 { font-size: 2.5rem; }
            .cards { flex-direction: column; align-items: center; }
            .card { width: 80%; margin-bottom: 20px; }
        }

    </style>
</head>
<body>

@if(session('success'))
<script>
    alert("Login successful");
</script>
@endif

<div class="dashboard">
    <h1>Welcome HR</h1>
    <p>Manage employees, departments, and leave records from one place</p>

    <div class="cards">
        <a href="/employees" class="card">
            <h2>Employees</h2>
            <p>Add, update, search and manage employee records</p>
        </a>

        <a href="/departments" class="card">
            <h2>Departments</h2>
            <p>Create and manage organizational departments</p>
        </a>

        <a href="{{ route('leave.history') }}" class="card">
            <h2>Leaves</h2>
            <p>View and manage employee leave requests</p>
        </a>

        <!-- Logout button styled like the back button -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>

    </div>
</div>

</body>
</html>
