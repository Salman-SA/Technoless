<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="styles/logo.png">
    <title>Products - Technoless</title>
    <link rel="stylesheet" href="styles/crud-styles.css">
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
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a></li>
        </ul>
    </nav>

    <section id="products">
        <div class="content">
            <h1>Products</h1>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h2><?php echo $product['name']; ?></h2>
                        <p><?php echo number_format($product['price'], 2); ?> SAR</p>
                        <a href="update_product.php?id=<?php echo $product['id']; ?>">Update</a>
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <footer>
        <p>© Technoless / 2024 IMAM / CCIS / IT dept.</p>
    </footer>
</body>
</html>
