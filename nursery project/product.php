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

// Pagination setup
$results_per_page = 3;
$sql = "SELECT * FROM products"; // Assuming your table name is 'products'
$result = mysqli_query($conn, $sql);
$number_of_results = mysqli_num_rows($result);
$number_of_pages = ceil($number_of_results / $results_per_page);

// Determine current page number
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// Calculate SQL LIMIT starting number for the results on the displaying page
$this_page_first_result = ($page - 1) * $results_per_page;

// Retrieve data for the current page
$sql = "SELECT * FROM products LIMIT $this_page_first_result, $results_per_page";
$result = mysqli_query($conn, $sql);

// Set a session variable to store the page number
$_SESSION['current_page'] = $page;

// Set a cookie to remember the user's last visited page
$cookie_name = "last_visited_page";
$cookie_value = $page;
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // Cookie set to expire in 30 days

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file here -->
</head>

<body>
    <header>
        <div class="container">
            <h1 style="text-decoration:none;"><a href="index.php">Nursery E-commerce</a></h1>
            <nav>
                <ul>
                    <li><a href="#featured">Featured</a></li>
                    <li><a href="product.php">Products</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="cont">
        <h1>Products</h1>
        <div class="prod">
            <?php
            // Display products
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='productse'>";
                echo "<img src='" . $row['image'] . "' alt='Plant'>";
                echo "<p>" . $row['name'] . "</p>";
                echo "<p>$" . $row['price'] . "</p>";
                echo "<form action='buy.php' method='post'>"; // Form to submit product ID to buy.php
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<input type='submit' value='Shop Now'>";
                echo "</form>";
                echo "</div>";
            }
            ?>
        </div>
        <div class="pagination">
            <?php
            // Display pagination links
            for ($page = 1; $page <= $number_of_pages; $page++) {
                echo '<a href="product.php?page=' . $page . '">' . $page . '</a> ';
            }
            ?>
        </div>
    </div>
</body>

</html>