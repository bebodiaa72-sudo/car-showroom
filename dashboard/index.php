<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

include "../config/db.php";

$result = $conn->query("SELECT * FROM cars");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="icon" type="image/png" href="../assets/images/logo.jpeg">

    <title>Dashboard</title>
</head>

<body class="body2">

<div class="container2">

    <h1>Cars Dashboard</h1>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'cant_delete'): ?>
        <div style="background:#f8d7da; color:#842029; padding:12px 20px; border-radius:8px; margin-bottom:16px;">
            ❌ Cannot delete this car — it has active orders!
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
        <div style="background:#d1e7dd; color:#0a5c36; padding:12px 20px; border-radius:8px; margin-bottom:16px;">
            ✅ Car deleted successfully!
        </div>
    <?php endif; ?>

    <a href="create.php">
        <button class="btn">+ Add Car</button>
    </a>
    <a href="orders.php">
        <button class="btn">📋 Orders</button>
    </a>
    <a href="../index.php">
        <button class="btn">← Home</button>
    </a>

    <div class="brands">

        <?php while($row = $result->fetch_assoc()): ?>

        <div class="brand">

            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo $row['brand']; ?></p>
            <p><?php echo $row['price']; ?></p>
            <p><?php echo $row['description']; ?></p>

            <div class="actions">

                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn edit">
                    Edit
                </a>

                <a href="delete.php?id=<?php echo $row['id']; ?>"
                   class="btn delete"
                   onclick="return confirm('Delete?')">
                    Delete
                </a>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

</body>
</html>