<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Tambahkan pengguna baru ke database jika belum ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if (!$user) {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute(['username' => $username, 'password' => $password]);
    }

    // Set session dan redirect
    $_SESSION['username'] = $username;
    header('Location: eventa.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eventa</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('background.png') no-repeat center center/cover;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .login-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        h1 {
            margin: 10px 0;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-group input {
            width: calc(100% - 40px);
            padding: 10px;
            margin-top: 5px;
            background: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #333;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            width: calc(100% - 40px);
            display: inline-block;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .password-container .toggle-password img {
            width: 20px;
            height: 20px;
        }

        .btn-login {
            background-color: #27ae60;
            padding: 15px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #2ecc71;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #ccc;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="logo">
            <img src="2.png" alt="Eventa Logo">
        </div>
        <h1>Login to Eventa</h1>

        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <button type="button" id="togglePassword" class="toggle-password">
                        <img src="eye-icon.png" alt="Show/Hide Password" id="passwordIcon">
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2025 Eventa. All Rights Reserved.</p>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Ganti ikon mata
            passwordIcon.src = type === 'password' ? 'eye-icon.png' : 'eye-slash-icon.png';
        });
    </script>

</body>

</html>