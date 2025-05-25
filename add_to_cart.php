<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Debug: Check if data is received
    file_put_contents('php://stderr', print_r($data, TRUE));

    $product_id = $data['product_id'];
    $product_name = $data['product_name'];
    $product_price = $data['product_price'];
    $quantity = $data['quantity'];
    $product_image = $data['product_image'];
    $user_id = 1; // Assume a logged-in user with id 1 for now

    $sql = "INSERT INTO cart (product_id, product_name, product_price, quantity, product_image, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Debug: Check if statement is prepared correctly
    if (!$stmt) {
        file_put_contents('php://stderr', print_r($pdo->errorInfo(), TRUE));
    }

    $stmt->execute([$product_id, $product_name, $product_price, $quantity, $product_image, $user_id]);

    echo json_encode(['status' => 'success']);
}
?>
