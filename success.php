<?php
include "auth.php";
include "config/db.php";

$order_id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT orders.*, cars.name AS car_name, cars.image AS car_image
    FROM orders
    JOIN cars ON orders.car_id = cars.id
    WHERE orders.id = ?
");

$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    header("Location: index.php");
    exit();
}

$remaining = $order['total_amount'] - $order['amount_paid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Order Confirmed - LUXURY</title>
</head>
<body class="body2">
<div class="container2">

    <?php include "header.php"; ?>

    <div class="brand" style="max-width:600px; margin:40px auto; text-align:center;">

        <i class="fas fa-check-circle" style="font-size:80px; color:#00ff88; margin-bottom:20px;"></i>

        <h2 style="color:white;">Order Confirmed!</h2>
        <p style="color:#aaa;">Thank you <?php echo $order['full_name']; ?>, your reservation has been placed successfully.</p>

        <div class="logo-box" style="margin:20px auto;">
            <img src="<?php echo $order['car_image']; ?>" alt="<?php echo $order['car_name']; ?>">
        </div>

        <h3 style="color:var(--main-color); margin-top:20px;">
            <?php echo $order['car_name']; ?>
        </h3>

        <div style="
            background:rgba(255,255,255,0.05);
            border:1px solid #444;
            border-radius:15px;
            padding:20px;
            margin-top:20px;
            text-align:left;
        ">
            <p style="color:#aaa;">Order ID: <strong style="color:white;">#<?php echo $order['id']; ?></strong></p>
            <p style="color:#aaa;">Name: <strong style="color:white;"><?php echo $order['full_name']; ?></strong></p>
            <p style="color:#aaa;">Phone: <strong style="color:white;"><?php echo $order['phone']; ?></strong></p>
            <p style="color:#aaa;">Address: <strong style="color:white;"><?php echo $order['address']; ?></strong></p>
            <p style="color:#aaa;">Total Price: <strong style="color:#00ff88;">$<?php echo number_format($order['total_amount'], 2); ?></strong></p>
            <p style="color:#aaa;">Deposit Paid: <strong style="color:#00ff88;">$<?php echo number_format($order['amount_paid'], 2); ?></strong></p>
            <p style="color:#aaa;">Remaining Amount: <strong style="color:#ff4444;">$<?php echo number_format($remaining, 2); ?></strong></p>
            <p style="color:#aaa;">Status: <strong style="color:#f39c12;">Pending</strong></p>
        </div>

        <p style="color:#aaa; margin-top:20px;">
            Please visit our showroom to pick up your car and pay the remaining amount.
        </p>

        <div style="display:flex; gap:15px; justify-content:center; margin-top:30px;">

            <a href="index.php">
                <button class="btn">Back to Home</button>
            </a>

            <a href="showroom.php">
                <button class="btn" style="background:transparent; border:1px solid #444;">
                    Browse More Cars
                </button>
            </a>

        </div>

    </div>

</div>
<script src="assets/JS/main.js"></script>
</body>
</html>