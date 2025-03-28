<?php
session_start();
include 'DBconfig.php';
include 'classes.php';

// Check if product ID and size are provided
if (!isset($_POST['product_id']) || !isset($_POST['size'])) {
    header("Location: shoe1.php?error=missing_data");
    exit();
}

$product_id = $_POST['product_id'];
$size = $_POST['size'];

// Fetch the product from the database
$sql = "SELECT PRODUCT_ID, PRODUCT_NAME, PRICE, BRAND, IMAGE FROM products WHERE PRODUCT_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    header("Location: shoe1.php?error=product_not_found");
    exit();
}

// Create a ShoeProduct object
$product = new ShoeProduct(
    $row['PRODUCT_ID'],
    $row['PRODUCT_NAME'],
    $row['PRICE'],
    $row['BRAND'],
    $row['IMAGE'],
    $conn
);

// Check if the selected size is in stock
if ($product->getSizeStock($size) <= 0) {
    header("Location: shoe1.php?error=out_of_stock");
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof Cart)) {
    $_SESSION['cart'] = new Cart();
}

// Retrieve the cart from the session
$cart = $_SESSION['cart'];

// Add the product to the cart
$quantity = 1; // Default quantity
$cart->addProduct($product, $quantity, $size);

// Save the updated cart back to the session
$_SESSION['cart'] = $cart;

// Redirect to the cart page
header("Location: cart.php");
exit();
?>