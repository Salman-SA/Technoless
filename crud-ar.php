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
<html lang="ar">
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
            <li><a href="home.php">الرئيسية</a></li>
            <li><a href="about.html">من نحن</a></li>
            <li><a href="contact.html">اتصل بنا</a></li>
            <li><a href="login.html">تسجيل الدخول</a></li>
            <li><a href="cart.html"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
        <div class="language-switch">
            <a href="crud.php">English</a>
        </div>
    </nav>

    <section id="crud">
        <div class="crud-content">
            <h1>المنتجات</h1>
            <a href="create_product.php" class="add-btn">إضافة منتج</a>
            <table>
                <thead>
                    <tr>
                        <th>الرقم التعريفي</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>الصورة</th>
                        <th>تحديث</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo number_format($product['price'], 2); ?> ريال</td>
                            <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                            <td><a href="update_product.php?id=<?php echo $product['id']; ?>" class="update-btn">تحديث</a></td>
                            <td><a href="delete_product.php?id=<?php echo $product['id']; ?>" class="delete-btn" onclick="return confirmDelete();">حذف</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <p>© Technoless / 2024 جامعة الإمام / كلية علوم الحاسب والمعلومات / قسم تقنية المعلومات</p>
    </footer>

    <script>
        function confirmDelete() {
            return confirm('هل أنت متأكد أنك تريد حذف هذا المنتج؟');
        }
    </script>
</body>
</html>
