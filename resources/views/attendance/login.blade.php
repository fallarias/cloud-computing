<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    background: url('/login.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 20px;
}

body::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    z-index: 0;
}

.login-container {
    position: relative;
    z-index: 1;
    background: rgba(255, 255, 255, 0.98);
    padding: 50px 40px;
    border-radius: 14px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
    width: 100%;
    max-width: 420px;
    text-align: center;
}

.login-container h1 {
    margin-bottom: 30px;
    color: #222;
    font-weight: 600;
    font-size: 28px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #444;
    font-weight: 600;
    font-size: 15px;
    text-align: left;
}

.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    margin-bottom: 25px;
    border: 1.5px solid #ccc;
    border-radius: 10px;
    font-size: 16px;
    transition: border 0.3s ease;
}

.login-container input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
}

.login-container button {
    width: 100%;
    padding: 14px;
    background-color: #007bff;
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-container button:hover {
    background-color: #0056b3;
}

/* Styled link as button */
.login-container .btn-primary {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 28px;
    background-color: #28a745;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.login-container .btn-primary:hover {
    background-color: #1e7e34;
}

.error-message {
    color: #d32f2f;
    margin-bottom: 20px;
    font-weight: 700;
    font-size: 15px;
}

@media (max-width: 480px) {
    .login-container {
        padding: 35px 25px;
        max-width: 100%;
    }

    .login-container h1 {
        font-size: 24px;
        margin-bottom: 25px;
    }

    label {
        font-size: 14px;
    }

    .login-container input,
    .login-container button,
    .login-container .btn-primary {
        font-size: 15px;
        padding: 12px;
    }

    .login-container .btn-primary {
        padding: 10px 20px;
        margin-top: 15px;
    }
}

    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('attendance.logins') }}">
            @csrf
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit">Login</button>
        </form>
        <a href="{{ route('attendance.staffAttendance') }}" class="btn btn-primary">Staff Attendance</a>


    </div>
</body>
</html>
