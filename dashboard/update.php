<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}
 include "../admin_auth.php"; 

include "../config/db.php";
?>
<?php include "../admin_auth.php"; ?>
<?php

$id = $_GET['id'];

$row = $conn->query("SELECT * FROM cars WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){

  $conn->query("UPDATE cars SET 
name='$_POST[name]',
brand='$_POST[brand]',
price='$_POST[price]',
description='$_POST[description]',
image='$_POST[image]'
WHERE id=$id");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="icon" type="image/png" href="../assets/images/logo.jpeg">

</head>

<body class="body2">

<div class="container2">

<h1>Update Car</h1>

<form method="POST" class="buy">

<input name="name" value="<?php echo $row['name']; ?>">
<input name="brand" value="<?php echo $row['brand']; ?>">
<input name="price" value="<?php echo $row['price']; ?>">
<input name="image" value="<?php echo $row['image']; ?>">
<textarea name="description"><?php echo $row['description']; ?></textarea>

<button class="btn" name="update">Update</button>

</form>

</div>

</body>
</html>