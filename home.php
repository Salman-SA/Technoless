<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="styles/logo.png">
    <title>Home - Technoless</title>
    <link rel="stylesheet" href="styles/home-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Added Font Awesome -->
</head>
<body>
    <nav>
        <div class="logo">
            <a href="index.html" class="logo-link"></a>
        </div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="contact.html">Contact Us</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a></li> <!-- Updated Cart link -->
        </ul>
        <div class="language-switch">
            <a href="home-ar.php">العربية</a>
        </div>
    </nav>

    <section id="home">
        <div class="content">
            <?php
            require 'db.php';

            $sql = "SELECT * FROM products";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product): ?>
                <div class="PC">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h2><?php echo $product['name']; ?></h2>
                    <p><?php echo number_format($product['price'], 2); ?> SAR</p>
                    <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <p>© Technoless / 2024 IMAM / CCIS / IT dept.</p>
    </footer>
    
<script src="cart.js"></script> <!-- Include the cart.js file -->

<script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-product-id');
            addToCart(productId);
        });
    });

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', () => {
        updateCartCount();
    });
</script>

</body>
</html>
