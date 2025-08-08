<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineshop";
$port = 3307; 

// Create connection - IMPORTANT: Pass the $port variable here!
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Remove from Cart Logic ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $product_id_to_remove = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id_to_remove])) {
        unset($_SESSION['cart'][$product_id_to_remove]);
    }
    header("Location: cart.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = max(1, intval($_POST['quantity']));
    $_SESSION['cart'][$product_id] = $new_quantity;
    header("Location: cart.php");
    exit();
}


$cart_items = [];
$total_price = 0;

if (!empty($_SESSION['cart'])) {
    // Get product IDs from the session cart
    $product_ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', $product_ids);

    // Fetch product details from the database for items in the cart
    $sql = "SELECT id, name, price FROM products WHERE id IN ($ids_string)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $quantity = $_SESSION['cart'][$row['id']];
            $row['quantity'] = $quantity;
            $row['subtotal'] = $row['price'] * $quantity;
            $cart_items[] = $row;
            $total_price += $row['subtotal'];
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

    <header>
        <h1>Your Shopping Cart</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
        </nav>
    </header>

    <main class="cart-container">
        <?php if (!empty($cart_items)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                            <td>
                                <form method="post" action="cart.php">
    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
    <button type="submit" name="update_quantity" class="btn btn-primary">Update</button>
    <button type="submit" name="remove_from_cart" class="btn btn-danger">Remove</button>
</form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-total">
    <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
</div>

        <?php else: ?>
            <p>Your cart is empty. <a href="index.php">Go shopping!</a></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 My Awesome Shop</p>
    </footer>

</body>
</html>