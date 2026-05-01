<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rahma Islamic Relief Center - HR Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; min-height: 100vh; overflow-x: hidden; }

        /* --- Welcome Section --- */
        #welcome-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(135deg, #1E88D9 0%, #0B5FA5 50%, #6DBE45 100%);
        }

        .hero { 
            text-align: center; 
            color: #FFFFFF; 
            margin-bottom: 50px; 
            animation: fadeInUp 1s ease-out; 
        }
        .hero h1 { 
            font-size: 3.5rem; 
            font-weight: 700; 
            margin-bottom: 10px; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3); 
        }
        .hero p { 
            font-size: 1.2rem; 
            font-weight: 300; 
            max-width: 600px; 
            margin: 0 auto; 
            line-height: 1.6; 
        }
        .logo { width: 150px; height: auto; margin-bottom: 20px; animation: fadeInUp 1s ease-out; }

        .features { display: flex; justify-content: space-around; width: 100%; max-width: 1200px; margin-bottom: 50px; }

        .feature {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            width: 30%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .feature:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.25); 
        }

        .feature h3 { 
            font-size: 1.5rem; 
            margin-bottom: 15px; 
            color: #FFFFFF; 
        }

        .feature p { 
            font-size: 1rem; 
            color: rgba(255, 255, 255, 0.9); 
        }

        /* CTA Button */
        .cta {
            background: linear-gradient(135deg, #1E88D9 0%, #6DBE45 100%);
            color: #FFFFFF;
            border-radius: 50px;
            padding: 20px 50px;
            font-weight: 600;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: pulse 2s infinite;
        }

        .cta:hover {
            background: linear-gradient(135deg, #0B5FA5 0%, #5FAE3D 100%);
            transform: scale(1.05);
        }

        /* --- Login Section --- */
        #login-section {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            /* Updated gradient to match logo colors */
            background: linear-gradient(135deg, #0B5FA5 0%, #1EAE5D 100%);
            z-index: 10;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        #login-section.active { 
            display: flex; 
            opacity: 1; 
        }

        .login-container { 
            display: flex; 
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            width: 100%; 
            height: 100%; 
        }

        .login-container h2 {
            color: #FFFFFF;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            font-size: 2.5rem;
            font-weight: 700;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.15); /* Slightly transparent to keep focus on logo colors */
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 50px; 
            width: 100%;
            max-width: 450px; 
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
        }

        .login-form h3 { 
            text-align: center; 
            margin-bottom: 20px; 
            color: #FFFFFF; 
            font-size: 1.8rem; 
            font-weight: 600;
        }

        .login-form input {
            width: 100%;
            padding: 18px; 
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            background: #FFFFFF;
            font-size: 1rem;
            color: #1F2937;
        }

        .login-form input::placeholder { color: #6B7280; }

        .login-form button {
            width: 100%;
            padding: 18px; 
            /* Button gradient to reflect logo colors */
            background: linear-gradient(135deg, #1E88D9 0%, #1EAE5D 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-form button:hover { 
            background: linear-gradient(135deg, #0B5FA5 0%, #159844 100%); 
        }

        /* Error */
        .login-error {
            color: #FFFFFF;
            background: rgba(239, 68, 68, 0.6);
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
        }

        /* Back Button */
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #FFFFFF;
            color: #1EAE5D;
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .back-btn:hover {
            background: #1EAE5D;
            color: #FFFFFF;
        }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0% { box-shadow: 0 10px 30px rgba(0,0,0,0.2); } 50% { box-shadow: 0 10px 30px rgba(0,0,0,0.4); } 100% { box-shadow: 0 10px 30px rgba(0,0,0,0.2); } }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .features { flex-direction: column; align-items: center; }
            .feature { width: 80%; margin-bottom: 20px; }
            .login-container { flex-direction: column; }
            .login-container h2 { font-size: 2rem; margin-bottom:20px; }
        }
    </style>
</head>
<body>
    
    <!-- Welcome Section -->
    <div id="welcome-section">
        <div class="hero">
            <img src="{{ asset('image.png') }}" alt="Rahma Islamic Relief Center Logo" class="logo">
            <h1>Welcome to Rahma Islamic Relief Center</h1>
            <p>We aspire to be a dynamic organization working towards creation of a just and caring society.</p>
        </div>

        <div class="features">
            <div class="feature">
                <h3>Mission</h3>
                <p>To improve the life quality of vulnerable people through sustainable development and ensure timely humanitarian assistance in need.</p>
            </div>
            <div class="feature">
                <h3>Efficient HR Management</h3>
                <p>Streamlined system for managing employee records, departments, and operations securely.</p>
            </div>
            <div class="feature">
                <h3>Community Support</h3>
                <p>Dedicated to serving the community with Islamic relief programs and humanitarian services.</p>
            </div>
        </div>

        <button class="cta" onclick="showLogin()">Access HR Portal</button>
    </div>

    <!-- ... your existing HTML head and welcome section remain unchanged ... -->

<!-- Login Section -->
<div id="login-section">
    <button class="back-btn" onclick="hideLogin()">← Back</button>
    <div class="login-container">

        <!-- LOGIN FORM -->
        <form class="login-form" id="login-form" method="POST" action="/login">
            @csrf
            <h3>Login</h3>
            @if(session('error'))
                <div class="login-error">{{ session('error') }}</div>
            @endif
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p style="color:white; text-align:center; margin-top:15px;">
                Don't have an account? 
                <span style="text-decoration:underline; cursor:pointer;" onclick="showSignup()">Sign Up</span>
            </p>
        </form>

        <!-- SIGNUP FORM -->
        <form class="login-form" id="signup-form" method="POST" action="/register" style="display:none;">
            @csrf
            <h3>Create Account</h3>
            @if($errors->any())
                <div class="login-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Create Account</button>
            <p style="color:white; text-align:center; margin-top:15px;">
                Already have an account? 
                <span style="text-decoration:underline; cursor:pointer;" onclick="showLoginForm()">Login</span>
            </p>
        </form>

    </div>
</div>

<!-- JS to toggle login/signup -->
<script>
    function showLogin() {
        document.getElementById('welcome-section').style.display = 'none';
        document.getElementById('login-section').classList.add('active');
        showLoginForm(); // Ensure login form shows by default
    }

    function hideLogin() {
        document.getElementById('login-section').classList.remove('active');
        setTimeout(() => {
            document.getElementById('welcome-section').style.display = 'flex';
        }, 500);
    }

    function showSignup() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('signup-form').style.display = 'block';
    }

    function showLoginForm() {
        document.getElementById('signup-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    }

    // Keep login panel open if error exists
    @if(session('error') || $errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                showLogin();
                @if($errors->any())
                    showSignup();
                @endif
            });
        @endif
</script>

</body>
</html>
