<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $sql = "UPDATE products SET name = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $price, $image, $id]);

        // Redirect to the main CRUD page after updating
        header('Location: crud.php');
        exit();
    }
} else {
    header('Location: crud.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="styles/logo.png">
    <title>Update Product - Technoless</title>
    <link rel="stylesheet" href="styles/crud-styles.css">
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
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
        
    </nav>

    <section id="crud">
        <div class="crud-content">
            <h1>Update Product</h1>
            <form action="update_product.php?id=<?php echo $product['id']; ?>" method="POST">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>
                
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" required>

                <label for="image">Image URL:</label>
                <input type="text" id="image" name="image" value="<?php echo $product['image']; ?>" required>

                <button type="submit">Update Product</button>
            </form>
        </div>
    </section>

    <footer>
        <p>© Technoless / 2024 IMAM / CCIS / IT dept.</p>
    </footer>
</body>
</html>
