<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* منع الكاش (مهم للـ back button) */
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* لو مش عامل login */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}
?>