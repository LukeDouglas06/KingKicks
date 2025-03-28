<?php
// Parent class
class Product {
    protected $product_id;
    protected $name;
    protected $price;
    protected $brand;
    protected $amountordered;
    protected $image;
    protected $sizes = [];

    public function __construct($product_id, $name, $price, $brand, $stock, $image) {
        $this->product_id = $product_id;
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;
        $this->stock = $stock;
        $this->image = $image;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getImage() {
        return $this->image;
    }
}

// Child class
class ShoeProduct extends Product {
    public function __construct($product_id, $name, $price, $brand, $image, $conn) {
        parent::__construct($product_id, $name, $price, $brand, null, $image); // Call parent constructor
        $this->fetchSizes($conn); // Fetch sizes from the database
    }

    public function getSizes() {
        return $this->sizes; // Return all sizes as an array
    }

    public function getSizeStock($size) {
        return $this->sizes[$size] ?? 0; // Return stock for a specific size
    }

    public function fetchSizes($conn) {
        $sql = "SELECT size, stock FROM shoe_sizes WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->sizes = []; // Reset sizes array
        while ($row = $result->fetch_assoc()) {
            $this->sizes[$row['size']] = $row['stock']; // Use size as the key and stock as the value
        }
    }
}

// Cart class (aggregation)
class Cart {
    private $items = []; // Array to store cart items

    public function addProduct(ShoeProduct $product, $quantity, $size) {
        $productId = $product->getProductId();
        if (isset($this->items[$productId][$size])) {
            // Update quantity if the product and size already exist in the cart
            $this->items[$productId][$size]['quantity'] += $quantity;
        } else {
            // Add a new product and size to the cart
            $this->items[$productId][$size] = [
                'product' => $product,
                'quantity' => $quantity,
                'size' => $size,
            ];
        }
    }

    public function getItems() {
        $cartItems = [];
        foreach ($this->items as $productId => $sizes) {
            foreach ($sizes as $size => $item) {
                $cartItems[] = $item;
            }
        }
        return $cartItems;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}

// OrderItem class (composition)
class OrderItem {
    private $product;
    private $quantity;
    private $size;

    public function __construct(ShoeProduct $product, $quantity, $size) {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->size = $size;
    }

    public function getTotalPrice() {
        return $this->product->getPrice() * $this->quantity;
    }

    public function getProduct() {
        return $this->product;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getSize() {
        return $this->size;
    }
}

// Order class (composition)
class Order {
    private $order_id;
    private $items = [];

    public function __construct($order_id) {
        $this->order_id = $order_id;
    }

    public function addItem(OrderItem $item) {
        $this->items[] = $item;
    }

    public function getTotalAmount() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }
        return $total;
    }
}
?>