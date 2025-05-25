<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="styles/logo.png">
    <title>الرئيسية - Technoless</title>
    <link rel="stylesheet" href="styles/home-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- أضفنا Font Awesome -->
</head>
<body>
    <nav>
        <div class="logo">
            <a href="index.html" class="logo-link"></a>
        </div>
        <ul>
            <li><a href="home-ar.php">الصفحه الرئيسية</a></li>
            <li><a href="about-ar.html">معلومات عنا</a></li>
            <li><a href="contact-ar.html">اتصل بنا</a></li>
            <li><a href="login-ar.html">تسجيل الدخول</a></li>
            <li><a href="cart-ar.html"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a></li> <!-- رابط السلة المحدث -->
        </ul>
        <div class="language-switch">
            <a href="home.php">English</a>
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
                    <p><?php echo number_format($product['price'], 2); ?> ريال سعودي</p>
                    <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">أضف إلى السلة</button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <p>© Technoless / 2024 IMAM / CCIS / IT dept.</p>
    </footer>
    
<script src="cart.js"></script>

</body>
</html>
