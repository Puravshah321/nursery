<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <input type="submit" value="Register">
        </form>
        <?php
            // Start session
            session_start();

            // Check if registration is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Database connection
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "nursery";

                $conn = new mysqli($host, $username, $password, $database);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Initialize error variables
                $username_err = $email_err = $password_err = $confirm_password_err = "";

                // Form validation
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Simple validation
                if ($password != $confirm_password) {
                    $confirm_password_err = "Passwords do not match";
                }

                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user into database if no errors
                if (empty($confirm_password_err)) {
                    $sql = "INSERT INTO register(username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='success'>User registered successfully</div>";
                    } else {
                        echo "<div class='error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }

                $conn->close();
            }
        ?>
        <div class="error"><?php echo $username_err; ?></div>
        <div class="error"><?php echo $email_err; ?></div>
        <div class="error"><?php echo $password_err; ?></div>
        <div class="error"><?php echo $confirm_password_err; ?></div>
    </div>
</body>
</html>
