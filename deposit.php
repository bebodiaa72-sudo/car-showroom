<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include "config/db.php";

$car_id = $_GET['car_id'];

$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();

$deposit = $car['price'] * 0.10;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pay Deposit</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .deposit-wrap {
            max-width: 500px;
            margin: 80px auto;
            background: linear-gradient(to left, rgb(0,0,0), rgb(20,20,81));
            border-radius: 16px;
            padding: 40px;
            color: white;
            text-align: center;
        }
        .deposit-wrap img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .deposit-amount {
            font-size: 32px;
            font-weight: 700;
            color: #a855f7;
            margin: 16px 0;
        }
        .deposit-wrap p {
            color: rgba(200,210,255,0.75);
            margin: 6px 0;
        }
        .btn-confirm {
            margin-top: 24px;
            background: linear-gradient(135deg, #4a6cf7, #a855f7);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .btn-confirm:hover { opacity: 0.85; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="deposit-wrap">
    <img src="<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>">
    <h2><?php echo $car['name']; ?></h2>
    <p><?php echo $car['brand']; ?></p>
    <p>Full Price: $<?php echo number_format($car['price']); ?></p>

    <div class="deposit-amount">
        Deposit (10%): $<?php echo number_format($deposit, 2); ?>
    </div>

    <form action="confirm_booking.php" method="POST">
        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
        <input type="hidden" name="deposit" value="<?php echo $deposit; ?>">
        <button type="submit" class="btn-confirm">Confirm & Pay</button>
    </form>
</div>

</body>
</html>