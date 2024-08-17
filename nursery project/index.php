<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery E-commerce</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Nursery E-commerce</h1>
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

    <section id="hero">
        <div class="hero-container">
            <h2>Welcome to Our Nursery</h2>
            <p>Explore our wide range of plants and gardening essentials.</p>
            <a href="#products" class="btn">Shop Now</a>
        </div>
    </section>

    <section id="featured">
        <div class="container">
            <h2>Featured Products</h2>
            <!-- Featured product cards -->
            <div class="product-card">
                <img src="img/12.jpg" alt="Plant">
                <h3>Beautiful Succulent</h3>
                <p>$10.99</p>
                <a href="#" class="btn">View Details</a>
            </div>
            <div class="product-card">
                <img src="img/49.jpg" alt="Plant">
                <h3>Exotic Orchid</h3>
                <p>$15.99</p>
                <a href="#" class="btn">View Details</a>
            </div>
            <div class="product-card">
                <img src="img/46.png" alt="Plant">
                <h3>Blooming Roses</h3>
                <p>$12.99</p>
                <a href="#" class="btn">View Details</a>
            </div>
        </div>
    </section>

    <section id="products">
        <div class="container">
            <h2>Our Products</h2>
            <!-- Product categories or grid -->
            <div class="product-category">
                <h3>Indoor Plants</h3>
                <img src="img/21.jpg" alt="Indoor Plants">
                <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="product-category">
                <h3>Outdoor Plants</h3>
                <img src="img/7.jpg" alt="Outdoor Plants">
                <a href="#" class="btn">Shop Now</a>
            </div>
            <div class="product-category">
                <h3>Gardening Tools</h3>
                <img src="img/22.jpg" alt="Gardening Tools">
                <a href="#" class="btn">Shop Now</a>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ullamcorper velit eget sapien congue, et varius ex bibendum. Nulla vel leo libero.</p>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>Have a question or need assistance? Feel free to contact us.</p>
            <form>
                <input type="text" placeholder="Your Name">
                <input type="email" placeholder="Your Email">
                <textarea placeholder="Your Message"></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 Nursery E-commerce. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
