<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"] {
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
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="index.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <div class="error"><?php echo isset($login_err) ? $login_err : ''; ?></div>
    </div>

    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection
        $host = "localhost"; // Assuming your database is on the same server
        $username = "root";
        $password = "";
        $database = "nursery";

        // Connect to the database
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Initialize error variable
        $login_err = "";

        // Retrieve username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to check if the user exists
        $sql = "SELECT * FROM register WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User exists, verify password
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct, start a new session
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                // Redirect to home page
                header("location: home.php");
                exit;
            } else {
                // Password is incorrect
                $login_err = "Invalid username or password";
            }
        } else {
            // User does not exist
            $login_err = "Invalid username or password";
        }

        // Close connection
        $conn->close();
    }
    ?>

</body>
</html>
