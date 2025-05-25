<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

require 'db.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="styles/logo.png">
    <title>CRUD - Technoless</title>
    <link rel="stylesheet" href="styles/crud-styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- أضفنا Font Awesome -->

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
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
        <div class="language-switch">
            <a href="crud-ar.php">العربية</a>
        </div>
    </nav>

    <section id="crud">
        <div class="crud-content">
            <h1>Products</h1>
            <a href="create_product.php" class="add-btn">ADD PRODUCT</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo number_format($product['price'], 2); ?> SAR</td>
                            <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                            <td><a href="update_product.php?id=<?php echo $product['id']; ?>" class="update-btn">Update</a></td>
                            <td><a href="delete_product.php?id=<?php echo $product['id']; ?>" class="delete-btn" onclick="return confirmDelete();">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <p>© Technoless / 2024 IMAM / CCIS / IT dept.</p>
    </footer>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this product?');
        }
    </script>
</body>
</html>
