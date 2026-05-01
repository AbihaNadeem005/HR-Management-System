<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee - Rahma Islamic Relief Center</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        h1 {
            color: #1565C0;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        select {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            background: white;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #42A5F5;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1);
        }

        .error-message {
            color: red;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
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

        .btn-secondary {
            background: linear-gradient(135deg, #78909C 0%, #546E7A 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(120, 144, 156, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #546E7A 0%, #37474F 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(120, 144, 156, 0.6);
        }

        .section-title {
            color: #1565C0;
            font-size: 1.3rem;
            font-weight: 600;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .section-title:first-of-type {
            margin-top: 0;
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

        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

        }
    </style>
</head>
<body>
<a href="{{ route('employees.index') }}" class="back-btn">← Back</a>

<div class="container">
    <div class="header">
        <h1>Add New Employee</h1>
        <p class="subtitle">Fill in the employee details below to add them to the system</p>
    </div>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="section-title">Personal Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="Emp_ID">Employee ID</label>
                <input type="text" name="Emp_ID" id="Emp_ID" value="{{ old('Emp_ID') }}">
                @error('Emp_ID')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Name">Full Name *</label>
                <input type="text" name="Name" id="Name" value="{{ old('Name') }}" required>
                @error('Name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Father_name">Father's Name</label>
                <input type="text" name="Father_name" id="Father_name" value="{{ old('Father_name') }}">
                @error('Father_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="CNIC">CNIC *</label>
                <input type="text" name="CNIC" id="CNIC" placeholder="XXXXX-XXXXXXX-X" value="{{ old('CNIC') }}" required>
                @error('CNIC')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Gender">Gender</label>
                <select name="Gender" id="Gender">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('Gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('Gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('Gender')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="DOB">Date of Birth</label>
                <input type="date" name="DOB" id="DOB" value="{{ old('DOB') }}">
                @error('DOB')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Religion">Religion</label>
                <input type="text" name="Religion" id="Religion" value="{{ old('Religion') }}">
                @error('Religion')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Nationality">Nationality</label>
                <input type="text" name="Nationality" id="Nationality" value="{{ old('Nationality') }}">
                @error('Nationality')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Qualification">Qualification</label>
                <input type="text" name="Qualification" id="Qualification" value="{{ old('Qualification') }}">
                @error('Qualification')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="section-title">Address Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="Domicile">Domicile</label>
                <input type="text" name="Domicile" id="Domicile" value="{{ old('Domicile') }}">
                @error('Domicile')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="District">District</label>
                <input type="text" name="District" id="District" value="{{ old('District') }}">
                @error('District')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="Present_Home_Address">Present Home Address</label>
                <input type="text" name="Present_Home_Address" id="Present_Home_Address" value="{{ old('Present_Home_Address') }}">
                @error('Present_Home_Address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="Permanent_Home_Address">Permanent Home Address</label>
                <input type="text" name="Permanent_Home_Address" id="Permanent_Home_Address" value="{{ old('Permanent_Home_Address') }}">
                @error('Permanent_Home_Address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="section-title">Contact Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="Phone_no">Phone Number</label>
                <input type="text" name="Phone_no" id="Phone_no" placeholder="+92-XXX-XXXXXXX" value="{{ old('Phone_no') }}">
                @error('Phone_no')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Email">Email Address</label>
                <input type="text" name="Email" id="Email" value="{{ old('Email') }}">
                @error('Email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="section-title">Employment Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="Date_of_joining">Date of Joining</label>
                <input type="date" name="Date_of_joining" id="Date_of_joining" value="{{ old('Date_of_joining') }}">
                @error('Date_of_joining')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Job_Type">Job Type</label>
                <input type="text" name="Job_Type" id="Job_Type" placeholder="e.g., Full-time, Part-time" value="{{ old('Job_Type') }}">
                @error('Job_Type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Designation">Designation</label>
                <input type="text" name="Designation" id="Designation" value="{{ old('Designation') }}">
                @error('Designation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Department">Department</label>
                <input type="text" name="Department" id="Department" value="{{ old('Department') }}">
                @error('Department')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Work_Location">Work Location</label>
                <input type="text" name="Work_Location" id="Work_Location" value="{{ old('Work_Location') }}">
                @error('Work_Location')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Source_of_Funding">Source of Funding</label>
                <input type="text" name="Source_of_Funding" id="Source_of_Funding" value="{{ old('Source_of_Funding') }}">
                @error('Source_of_Funding')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="section-title">Salary Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="Starting_Salary">Starting Salary</label>
                <input type="text" name="Starting_Salary" id="Starting_Salary" value="{{ old('Starting_Salary') }}">
                @error('Starting_Salary')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Current_Salary">Current Salary</label>
                <input type="text" name="Current_Salary" id="Current_Salary" value="{{ old('Current_Salary') }}">
                @error('Current_Salary')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="section-title">Additional Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="Probation_Ending_Date">Probation Ending Date</label>
                <input type="date" name="Probation_Ending_Date" id="Probation_Ending_Date" value="{{ old('Probation_Ending_Date') }}">
                @error('Probation_Ending_Date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="Date_of_Leaving">Date of Leaving</label>
                <input type="date" name="Date_of_Leaving" id="Date_of_Leaving" value="{{ old('Date_of_Leaving') }}">
                @error('Date_of_Leaving')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="Final_Settlement">Final Settlement</label>
                <input type="text" name="Final_Settlement" id="Final_Settlement" value="{{ old('Final_Settlement') }}">
                @error('Final_Settlement')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">Add Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
