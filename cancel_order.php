<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include "config/db.php";

$order_id = $_GET['id'];
$user_id  = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();

header("Location: profile.php");
exit();
?>