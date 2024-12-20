<?php
session_start();
include '../config/db.php';

$error_msg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all the required fields are set
    if (isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['role'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']); // Capturing role from form input
        $email = mysqli_real_escape_string($conn, $_POST['email']); // Capturing email

        // Validate email (ensure it's not empty and in a valid format)
        if (empty($email)) {
            $error_msg = "Email cannot be empty.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "Please enter a valid email address.";
        } else {
            // Check if the username or email already exists
            $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $result = mysqli_query($conn, $check_query);
            
            if (mysqli_num_rows($result) > 0) {
                // Username or email already exists
                $error_msg = "Username or email is already taken. Please choose a different one.";
            } else {
                // Hash password for security
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // SQL Query to insert user into the users table
                $query = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$hashed_password', '$email', '$role')";

                if (mysqli_query($conn, $query)) {
                    $_SESSION['success_msg'] = "Registration successful!";
                    header('Location: login.php');
                    exit();
                } else {
                    $error_msg = "Error: " . mysqli_error($conn);
                }
            }
        }
    } else {
        $error_msg = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* General Page Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-footer {
            margin-top: 10px;
        }

        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .error-msg {
            color: red;
            margin-bottom: 15px;
        }

        .success-msg {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Register</h2>
        <?php if (isset($error_msg)) { echo "<div class='error-msg'>$error_msg</div>"; } ?>
        <?php if (isset($_SESSION['success_msg'])) { echo "<div class='success-msg'>{$_SESSION['success_msg']}</div>"; unset($_SESSION['success_msg']); } ?>
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="email" name="email" placeholder="Enter email" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Register</button>
        <div class="form-footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>
</body>
</html>
