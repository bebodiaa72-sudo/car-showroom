<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

include "../config/db.php";

$id = $_GET['id'];

$check = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE car_id = ?");
$check->bind_param("i", $id);
$check->execute();
$result = $check->get_result()->fetch_assoc();

if($result['total'] > 0){
    header("Location: index.php?error=cant_delete");
    exit();
}

$conn->query("DELETE FROM cars WHERE id=$id");
header("Location: index.php?success=deleted");
exit();
?>