<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top left, #2d89ef, #1b1f3a);
            overflow: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            filter: blur(120px);
            opacity: 0.4;
        }

        body::before {
            background: #2d89ef;
            top: -100px;
            left: -100px;
        }

        body::after {
            background: #00c6ff;
            bottom: -100px;
            right: -100px;
        }

        .card {
            position: relative;
            width: 360px;
            padding: 30px;
            border-radius: 18px;

            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);

            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            color: white;
            z-index: 1;

            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            opacity: 0.7;
            margin-bottom: 20px;
        }

        label {
            font-size: 12px;
            opacity: 0.8;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 6px 0 12px;
            border-radius: 10px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.15);
            color: white;
        }

        input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        select option {
            color: black;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #2d89ef, #00c6ff);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            transform: scale(1.03);
        }

        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .link a {
            color: #00c6ff;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Create Account</h2>
    <div class="subtitle">Register to access Loan System</div>

    <form method="POST" action="/LoanManagement/public/index.php?url=auth/storeRegister">

        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>

        <button type="submit">Register</button>

    </form>

    <div class="link">
        Already have an account?
        <a href="/LoanManagement/public/index.php?url=auth/login">Login</a>
    </div>

</div>

</body>
</html>