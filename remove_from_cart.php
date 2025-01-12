<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    // Optionally send a response
    echo json_encode(['status' => 'success']);
    exit();
}

// If not POST request or missing product_id
header("HTTP/1.1 400 Bad Request");
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
exit();
