<?php
session_start(); // Start the session

// Your database connection code here
$host = "localhost";
$username = "root";
$password = "";
$database = "nursery";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a random token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Check if product ID is set and not empty
if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Fetch product details from the database based on the product ID
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    // Check if product exists
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID is missing.";
}

// Set or regenerate the token if it doesn't exist or is empty
if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
    $_SESSION['token'] = generateToken();
}

// Check if form is submitted and the session token matches
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
    // Validate and sanitize user inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars($_POST['address']);
    $product_id = $_POST['product_id'];

    // Check if any field is empty
    if (empty($name) || empty($email) || empty($address)) {
        echo "All fields are required.";
    } else {
        // Insert user details and product ID into the cart table
        // Prepare and bind the SQL statement
        $sql = "INSERT INTO cart (name, email, address, product_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $address, $product_id);

        // Set parameters and execute the statement
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $product_id = $_POST['product_id'];

        if ($stmt->execute()) {
            echo "Order placed successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    echo "Invalid form submission.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <style>
       <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .cont {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            text-align: center;
        }

        .product-details {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .productse {
            width: 300px;
            margin: 10px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .productse img {
            max-width: 100%;
            border-radius: 8px;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
    </style>
</head>
<body>
    <header>
        <!-- Your header content here -->
    </header>
    <div class="cont">
        <h1>Buy Product</h1>
        <div class="product-details">
            <?php if (isset($product)) : ?>
                <div class='productse'>
                    <img src='<?php echo $product['image']; ?>' alt='Plant'>
                    <p><?php echo $product['name']; ?></p>
                    <p>$<?php echo $product['price']; ?></p>
                </div>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="4" required></textarea><br>
                    <input type="submit" value="Purchase">
                </form>
            <?php else : ?>
                <p>No product found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>