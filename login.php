<?php
session_start();
include '../config/db.php';  // Include the database connection file

$error_msg = ''; // To store error messages

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input to avoid SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];  // Plain password from the form

    // SQL query to fetch user from the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Check if user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables upon successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../grading/index.php'); // Redirect to the grading page
        exit();
    } else {
        // Invalid username or password
        $error_msg = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .auth-box h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .error-msg {
            color: #ff4d4f;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 15px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .input-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
        }

        .auth-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .auth-btn:hover {
            background-color: #0056b3;
        }

        .signup-link {
            text-align: center;
            margin-top: 10px;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h2>Login</h2>
            <?php if (!empty($error_msg)) { echo "<div class='error-msg'>$error_msg</div>"; } ?>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="auth-btn">Login</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
