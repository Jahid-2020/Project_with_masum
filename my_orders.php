<?php
session_start();

// যদি ইউজার লগইন না করে থাকে, তাহলে redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "onlineshop";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Get user orders
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="mb-4 text-center">📋 My Orders</h2>

        <?php if ($orders_result->num_rows > 0): ?>
            <?php while ($order = $orders_result->fetch_assoc()): ?>
                <div class="mb-4 border p-3 rounded bg-white">
                    <h5>🆔 Order ID: <?php echo $order['id']; ?></h5>
                    <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>
                    <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
                    <p><strong>Total:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
                    <p><strong>Placed on:</strong> <?php echo $order['created_at']; ?></p>

                    <h6 class="mt-3">🛍️ Items:</h6>
                    <ul>
                        <?php
                        $order_id = $order['id'];
                        $item_sql = "SELECT * FROM order_items WHERE order_id = ?";
                        $item_stmt = $conn->prepare($item_sql);
                        $item_stmt->bind_param("i", $order_id);
                        $item_stmt->execute();
                        $items_result = $item_stmt->get_result();

                        while ($item = $items_result->fetch_assoc()) {
                            echo "<li>{$item['product_name']} - {$item['quantity']} x \${$item['price']} = \$" . number_format($item['subtotal'], 2) . "</li>";
                        }
                        $item_stmt->close();
                        ?>
                    </ul>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">❌ You have not placed any orders yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
