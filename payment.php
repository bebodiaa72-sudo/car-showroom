<?php
include "auth.php";
include "config/db.php";

$car_id = isset($_POST['car_id']) ? $_POST['car_id'] : $_GET['id'];
$result = $conn->query("SELECT * FROM cars WHERE id=$car_id");
$car = $result->fetch_assoc();

$deposit = $car['price'] * 0.10;

$check = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE car_id = ? AND payment_status != 'cancelled'");
$check->bind_param("i", $car_id);
$check->execute();
$already_booked = $check->get_result()->fetch_assoc()['total'];

if($already_booked > 0){
    header("Location: showroom.php?error=already_booked");
    exit();
}

if(isset($_POST['submit'])){
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];
    $total = $car['price'];
    $paid = $deposit;

    $stmt = $conn->prepare("
        INSERT INTO orders(user_id, car_id, full_name, phone, address, payment_status, total_amount, amount_paid)
        VALUES(?, ?, ?, ?, ?, 'pending', ?, ?)
    ");

    $stmt->bind_param(
        "iisssdd",
        $user_id,
        $car_id,
        $full_name,
        $phone,
        $address,
        $total,
        $paid
    );

    $stmt->execute();

    header("Location: success.php?id=" . $stmt->insert_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Payment - LUXURY</title>
</head>
<body class="body2">
<div class="container2">

    <?php include "header.php"; ?>

    <div class="brand" style="max-width:500px; margin:40px auto; text-align:center;">

        <h3 style="color:var(--main-color);">Secure Checkout</h3>
        <p>Car: <strong style="color:white;"><?php echo $car['name']; ?></strong></p>
        <p>Total Price: <strong style="color:#00ff88;">$<?php echo number_format($car['price'], 2); ?></strong></p>
        <p>Deposit Required Now (10%): <strong style="color:#00ff88;">$<?php echo number_format($deposit, 2); ?></strong></p>

        <form method="POST" class="form-style" style="margin-top:30px;">
            <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">

            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>

            <div style="text-align:left;">
                <label>Card Number</label>
                <div style="position:relative;">
                    <input type="text" placeholder="1234 5678 9101 1121" required>
                    <i class="fab fa-cc-visa" style="position:absolute; right:10px; top:12px; color:#ccc;"></i>
                </div>
            </div>

            <div style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <input type="text" placeholder="MM/YY" required>
                </div>
                <div style="flex:1;">
                    <input type="password" placeholder="CVV" required>
                </div>
            </div>

            <button type="submit" name="submit" class="btn" style="width:100%;">
                Pay $<?php echo number_format($deposit, 2); ?> Now
            </button>

        </form>

        <a href="showroom.php">
            <button class="btn" style="margin-top:10px; background:transparent; border:1px solid #444; width:100%;">
                Cancel
            </button>
        </a>

    </div>

</div>
<script src="assets/JS/main.js"></script>
</body>
</html>