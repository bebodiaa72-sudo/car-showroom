<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include "config/db.php";

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("
    SELECT o.*, c.name AS car_name, c.brand, c.price, c.image,
        o.created_at AS booking_date, o.payment_status AS status, o.amount_paid AS deposit_amount
    FROM orders o
    JOIN cars c ON o.car_id = c.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$bookings = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/images/logo.jpeg">

    <style>
        .profile-wrap {
            max-width: 800px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .profile-card {
            background: linear-gradient(to left, rgb(0,0,0), rgb(20,20,81));
            border-radius: 16px;
            padding: 30px;
            color: white;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a6cf7, #a855f7);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .profile-info h2 { margin: 0 0 6px; font-size: 22px; }

        .profile-info p {
            margin: 4px 0;
            color: rgba(200, 210, 255, 0.75);
            font-size: 14px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a4e;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e0f0;
        }

        .booking-card {
            background: white;
            border: 1px solid #e0e0f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .booking-card img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .booking-card h4 { margin: 0 0 6px; color: #1a1a4e; font-size: 16px; }
        .booking-card p  { margin: 3px 0; color: #666; font-size: 13px; }

        .status-badge {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending   { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1e7dd; color: #0a5c36; }
        .status-cancelled { background: #f8d7da; color: #842029; }

        .btn-details {
            font-size: 12px;
            color: #4a6cf7;
            text-decoration: none;
            border: 0.5px solid #4a6cf7;
            padding: 4px 12px;
            border-radius: 6px;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-details:hover { background: #4a6cf7; color: white; }

        .btn-cancel {
            font-size: 12px;
            color: #dc3545;
            text-decoration: none;
            border: 0.5px solid #dc3545;
            padding: 4px 12px;
            border-radius: 6px;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-cancel:hover { background: #dc3545; color: white; }

        .no-bookings {
            text-align: center;
            padding: 40px;
            color: #999;
            background: #f9f9ff;
            border-radius: 12px;
            border: 1px dashed #c0c0e0;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="profile-wrap">

    <div class="profile-card">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
        </div>
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Member since: <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
        </div>
    </div>

    <h3 class="section-title">My Orders</h3>

    <?php if ($bookings->num_rows > 0): ?>
        <?php while ($b = $bookings->fetch_assoc()): ?>
        <div class="booking-card">
            <img src="<?php echo $b['image']; ?>" alt="<?php echo $b['car_name']; ?>">
            <div style="flex:1;">
                <h4><?php echo htmlspecialchars($b['car_name']); ?> — <?php echo htmlspecialchars($b['brand']); ?></h4>
                <p>Full Price: $<?php echo number_format($b['price']); ?></p>
                <p>Deposit Paid (10%): $<?php echo number_format($b['deposit_amount'], 2); ?></p>
                <p>Order Date: <?php echo date('d M Y', strtotime($b['booking_date'])); ?></p>
            </div>
            <div style="display:flex; flex-direction:column; align-items:center; gap:8px;">
                <span class="status-badge status-<?php echo $b['status']; ?>">
                    <?php
                        $statuses = [
                            'pending'   => 'Pending',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled'
                        ];
                        echo $statuses[$b['status']] ?? $b['status'];
                    ?>
                </span>
                <a href="success.php?id=<?php echo $b['id']; ?>" class="btn-details">
                    View Details
                </a>
                <a href="cancel_order.php?id=<?php echo $b['id']; ?>"
                onclick="return confirm('Are you sure you want to cancel?')"
                class="btn-cancel">
                    Cancel
                </a>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-bookings">
            <p>You have no orders yet.</p>
            <a href="showroom.php" class="btn" style="margin-top:12px; display:inline-block;">Browse Cars</a>
        </div>
    <?php endif; ?>

</div>

</body>
</html>