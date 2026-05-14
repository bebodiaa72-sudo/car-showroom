<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

include "../config/db.php";

if(isset($_GET['status']) && isset($_GET['id'])){
    $order_id = $_GET['id'];
    $status = $_GET['status'];
    $allowed = ['pending', 'confirmed', 'cancelled'];
    if(in_array($status, $allowed)){
        $stmt = $conn->prepare("UPDATE orders SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();
    }
    header("Location: orders.php");
    exit();
}

$orders = $conn->query("
    SELECT o.*, u.username, c.name AS car_name, c.brand
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN cars c ON o.car_id = c.id
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Orders - Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 20px;
        }

        th {
            background: rgba(74, 108, 247, 0.3);
            color: white;
            padding: 12px 16px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 12px 16px;
            color: #ccc;
            font-size: 13px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        tr:hover td { background: rgba(255,255,255,0.03); }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending   { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1e7dd; color: #0a5c36; }
        .status-cancelled { background: #f8d7da; color: #842029; }

        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; }

        .btn-sm {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-confirm  { background: #d1e7dd; color: #0a5c36; }
        .btn-cancel   { background: #f8d7da; color: #842029; }
        .btn-pending  { background: #fff3cd; color: #856404; }
    </style>
</head>

<body class="body2">

<div class="container2">

    <h1>Orders Dashboard</h1>

    <a href="index.php">
        <button class="btn">← Back to Cars</button>
    </a>

    <p style="color:#aaa; margin-top:10px;">
        Total Orders: <strong style="color:white;"><?php echo $orders->num_rows; ?></strong>
    </p>

    <?php if($orders->num_rows > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Car</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Deposit</th>
            <th>Remaining</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while($o = $orders->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $o['id']; ?></td>
            <td>
                <?php echo htmlspecialchars($o['username']); ?><br>
                <small style="color:#888;"><?php echo htmlspecialchars($o['full_name']); ?></small>
            </td>
            <td><?php echo htmlspecialchars($o['car_name']); ?> — <?php echo htmlspecialchars($o['brand']); ?></td>
            <td><?php echo htmlspecialchars($o['phone']); ?></td>
            <td style="color:#00ff88;">$<?php echo number_format($o['total_amount'], 2); ?></td>
            <td style="color:#4a6cf7;">$<?php echo number_format($o['amount_paid'], 2); ?></td>
            <td style="color:#ff4444;">$<?php echo number_format($o['total_amount'] - $o['amount_paid'], 2); ?></td>
            <td>
                <span class="status-badge status-<?php echo $o['payment_status']; ?>">
                    <?php
                        $statuses = ['pending'=>'Pending','confirmed'=>'Confirmed','cancelled'=>'Cancelled'];
                        echo $statuses[$o['payment_status']] ?? $o['payment_status'];
                    ?>
                </span>
            </td>
            <td><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
            <td>
                <div class="action-btns">
                    <?php if($o['payment_status'] != 'confirmed'): ?>
                        <a href="orders.php?id=<?php echo $o['id']; ?>&status=confirmed" class="btn-sm btn-confirm">Confirm</a>
                    <?php endif; ?>
                    <?php if($o['payment_status'] != 'pending'): ?>
                        <a href="orders.php?id=<?php echo $o['id']; ?>&status=pending" class="btn-sm btn-pending">Pending</a>
                    <?php endif; ?>
                    <?php if($o['payment_status'] != 'cancelled'): ?>
                        <a href="orders.php?id=<?php echo $o['id']; ?>&status=cancelled"
                        class="btn-sm btn-cancel"
                        onclick="return confirm('Cancel this order?')">Cancel</a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php else: ?>
        <div style="text-align:center; padding:40px; color:#aaa;">
            <p>No orders yet.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>