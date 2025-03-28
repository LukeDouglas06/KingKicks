<?php
session_start();
include 'classes.php';

// Retrieve the cart from the session
if (!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof Cart)) {
    $_SESSION['cart'] = new Cart(); // Initialize the cart if it doesn't exist
}
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Kicks</title>
    <link rel="stylesheet" href="css/cart.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header>
    <section class="nav">
        <ul>
            <li><a href="homepage.php"><img src="images/White_KingKicks.png" width="60" height="50"></a></li>
            <li class="dropdown">
                <a href="brands.php">Brands</a>
                <div class="dropdown-content">
                    <a href="Nike.php">Nike</a>
                    <a href="Jordan.php">Jordan</a>
                    <a href="NewBalance.php">New Balance</a>
                    <a href="Yeezys.php">Yeezys</a>
                </div>
            </li>
            <li><a href="all.php">Shop All</a></li>
            <li><a href="new.php">New</a></li>
            <li><a href="sale.php">Sale</a></li>
            <li><input type="text" placeholder="Search"></li>
            <li>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="profile.php">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php else: ?>
                    <a href="login.php"><img src="images/login.png" width="50" height="50"></a>
                <?php endif; ?>
            </li>
            <li><a href="cart.php"><img src="images/cart.png" width="50" height="50" alt="Cart"></a></li>
        </ul>
    </section>
</header>

<div class="cart">
    <?php
    $cartItems = $cart->getItems();
    if (empty($cartItems)) {
        echo "<p>Your cart is empty.</p>";
    } else {
        echo "<table class='cart-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Product</th>";
        echo "<th>Size</th>";
        echo "<th>Price</th>";
        echo "<th>Quantity</th>";
        echo "<th>Total</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($cartItems as $item) {
            $product = $item['product'];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product->getName()) . "</td>";
            echo "<td>" . htmlspecialchars($item['size']) . "</td>";
            echo "<td>€" . htmlspecialchars($product->getPrice()) . "</td>";
            echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
            echo "<td>€" . ($product->getPrice() * $item['quantity']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<h3>Total Price: €" . $cart->getTotalPrice() . "</h3>";
    }
    ?>

<footer>
    <div class="footer-content">
        <ul>
            <h3>Contact Us</h3>
            <p>Email: KingKicks@Gmail.com</p>
            <p>Phone: 123-456-7890</p>
            <p>Address: 123 KingKicks Lane</p>
        </ul>
    </div>
    <div class="footer-content">
        <ul>
            <h3>Founders</h3>
            <p>Favour Godson</p>
            <p>Luke Douglas</p>
            <p>Nathan Lynch</p>
        </ul>
    </div>
    <div class="footer-content">
        <ul>
            <h3>Follow Us</h3>
            <li class="social-icons">
                <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
            </li>
        </ul>
    </div>
</footer>
</body>
</html>