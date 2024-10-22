<?php
require 'config.php';
session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Cek apakah username ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set sesi pengguna jika login berhasil
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // Jika ada ID di database

            // Redirect ke halaman dashboard atau halaman lain
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Username atau password salah!";
        }
    } else {
        echo "Username atau password salah!";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #FDFCE8 0%, #E2CEB1 99%, #E2CEB1 100%);
        }
        .login-container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }
        .login-container::before {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            z-index: -1;
        }
        .login-container .avatar {
            background: #C7407A;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container .avatar i {
            color: white;
            font-size: 40px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.5);
            color: #2c3e50;
            font-size: 16px;
        }
        .login-container input[type="checkbox"] {
            margin-right: 10px;
        }
        .login-container label {
            color: #2c3e50;
            font-size: 14px;
        }
        .login-container .forgot-password {
            float: right;
            color: #2c3e50;
            font-size: 14px;
            text-decoration: none;
        }
        .login-container .login-btn,
        .login-container .signup-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #C7407A;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .login-container .signup-btn {
            background: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="avatar">
            <i class="fas fa-user"></i>
        </div>
        <form method="POST" action="">
            <div>
                <i class="fas fa-user" style="position: absolute; margin-left: -30px; margin-top: 15px;"></i>
                <input type="text" name="username" placeholder="Email ID" required>
            </div>
            <div>
                <i class="fas fa-lock" style="position: absolute; margin-left: -30px; margin-top: 15px;"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div style="text-align: left;">
                <input type="checkbox" id="remember-me">
                <label for="remember-me">Remember me</label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit" class="login-btn">LOGIN</button>
        </form>
        <button class="signup-btn" onclick="window.location.href='signup.php'">SIGN UP</button>
    </div>
</body>
</html>