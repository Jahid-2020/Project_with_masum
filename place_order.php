<?php
session_start();

// যদি cart না থাকে, তাহলে redirect করো
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineshop";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User info
$customer_name = $_POST['customer_name'];
$address = $_POST['address'];

$total_price = 0;
$order_items = [];

// Product details fetch
$product_ids = implode(',', array_keys($_SESSION['cart']));
$sql = "SELECT id, name, price FROM products WHERE id IN ($product_ids)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quantity = $_SESSION['cart'][$row['id']];
        $subtotal = $row['price'] * $quantity;
        $total_price += $subtotal;

        $order_items[] = [
            'product_name' => $row['name'],
            'price' => $row['price'],
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
    }
}

// 1. Insert into `orders` table
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$stmt = $conn->prepare("INSERT INTO orders (customer_name, address, total_price, user_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssdi", $customer_name, $address, $total_price, $user_id);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// 2. Insert into `order_items` table
foreach ($order_items as $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isddi", $order_id, $item['product_name'], $item['price'], $item['quantity'], $item['subtotal']);
    $stmt->execute();
    $stmt->close();
}

// Cart clear
unset($_SESSION['cart']);
unset($_SESSION['cart_time']);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="text-center mt-5">
    <div class="container">
        <h1 class="text-success">🎉 Order Placed Successfully!</h1>
        <p>Thank you, <?php echo htmlspecialchars($customer_name); ?>! Your order has been recorded.</p>
        <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
    </div>
</body>
</html>
