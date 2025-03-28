<?php
session_start(); // Start the session at the top of the file

include 'C:\laragon\www\KingKicks\DBconfig.php'; // Include database connection
include 'C:\laragon\www\KingKicks\classes.php'; // Include classes
// Fetch recently searched products
$sql_recent = "SELECT * FROM products";
$stmt_recent = $conn->query($sql_recent);
$recent_products = $stmt_recent->fetch_all(MYSQLI_ASSOC);
$trending_products = $stmt_recent->fetch_all(MYSQLI_ASSOC);
// Check if the cart exists and is valid
if (isset($_SESSION['cart']) && $_SESSION['cart'] instanceof Cart) {
    $cart_count = count($_SESSION['cart']->getProducts());
} else {
    $cart_count = 0; // Default to 0 if the cart is not valid
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Kicks</title>
    <link rel="stylesheet" href="css/home.css">
    <script src="js/home.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

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
                <li><a href="cart.php"><img src="images/cart.png" width="50" height="50" alt="Cart">
                <span class="cart-count"><?php echo $cart_count; ?></span></a></li>
            </ul>
        </section>
    </header>
    <body>
    <h2>Recently Searched Products</h2>
    <section class="recently">
        <?php foreach ($recent_products as $product): ?>
            <div class="product-box">
                <a href="shoe<?php echo $product['PRODUCT_ID']; ?>.php">
                    <img src="/KingKicks/images/<?php echo $product['image']; ?>" alt="<?php echo $product['PRODUCT_NAME']; ?>">
                </a>
                <div class="price">€<?php echo $product['PRICE']; ?></div>
            </div>
        <?php endforeach; ?>
    </section>
    
    </section>
    <h2></h2>
    <section class="trending">
    <?php foreach ($trending_products as $product): ?>
            <div class="product-box">
                <a href="shoe<?php echo $product['PRODUCT_ID']; ?>.php">
                    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['PRODUCT_NAME']; ?>">
                </a>
                <div class="price">€<?php echo $product['PRICE']; ?></div>
            </div>
        <?php endforeach; ?>
    </section>
    
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