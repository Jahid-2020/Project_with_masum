<?php
session_start();
require_once 'db.php';

$query = "SELECT * FROM product ORDER BY created_at DESC LIMIT 6";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ShopSmart | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: 0.3s;
        }
        .product-card:hover {
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .product-image {
            height: 150px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">ShopSmart</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="profile.php">My Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.php?logout=true">Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Latest Products</h2>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="product-card">
                <img src="<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-fluid product-image">
                <h5 class="mt-2"><?= htmlspecialchars($row['name']) ?></h5>
                <p>Price: $<?= $row['price'] ?></p>
                <?php if ($row['discount'] > 0): ?>
                    <p><span class="badge badge-success"><?= $row['discount'] ?>% OFF</span></p>
                <?php endif; ?>
                <button class="btn btn-primary">Buy Now</button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
