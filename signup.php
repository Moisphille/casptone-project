<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah ada
    $check_user = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $check_user->bind_param("ss", $username, $email);
    $check_user->execute();
    $result = $check_user->get_result();

    if ($result->num_rows > 0) {
        echo "Username atau Email sudah terdaftar!";
    } else {
        // Menyimpan data ke database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Pendaftaran berhasil!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up Page</title>
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
        .signup-container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }
        .signup-container::before {
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
        .signup-container .avatar {
            background: #C7407A;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .signup-container .avatar i {
            color: white;
            font-size: 40px;
        }
        .signup-container input[type="text"],
        .signup-container input[type="email"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.5);
            color: #2c3e50;
            font-size: 16px;
        }
        .signup-container .signup-btn {
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
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="avatar">
            <i class="fas fa-user-plus"></i>
        </div>
        <form method="POST" action="">
            <div>
                <i class="fas fa-user" style="position: absolute; margin-left: -30px; margin-top: 15px;"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div>
                <i class="fas fa-envelope" style="position: absolute; margin-left: -30px; margin-top: 15px;"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div>
                <i class="fas fa-lock" style="position: absolute; margin-left: -30px; margin-top: 15px;"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="signup-btn">SIGN UP</button>
        </form>
    </div>
</body>
</html>