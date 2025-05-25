<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Debug: Check if data is received
    if (!$data) {
        error_log("No data received in POST request.");
        echo json_encode(['status' => 'error', 'message' => 'No data received']);
        exit();
    }

    $product_id = $data['product_id'] ?? null;
    $user_id = 1; // Assume a logged-in user with id 1 for now

    if ($product_id === null) {
        error_log("Product ID is missing in POST data.");
        echo json_encode(['status' => 'error', 'message' => 'Product ID is missing']);
        exit();
    }

    $sql = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);

    // Debug: Check if statement is prepared correctly
    if (!$stmt) {
        error_log(print_r($pdo->errorInfo(), true));
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
        exit();
    }

    $stmt->execute([$product_id, $user_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No rows affected']);
    }
}
?>
