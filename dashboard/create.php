<?php
include "../admin_auth.php";
include "../config/db.php";

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("
        INSERT INTO cars(name,brand,price,description,image)
        VALUES(?,?,?,?,?)
    ");

    $stmt->bind_param(
        "sssss",
        $name,
        $brand,
        $price,
        $description,
        $image
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
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

    <h1>Add Car</h1>

    <form method="POST" class="buy form-style">
        <input name="name" placeholder="Name" required>
        <input name="brand" placeholder="Brand" required>
        <input name="price" placeholder="Price" required>
        <input name="image" placeholder="Image Path" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button class="btn" name="submit">Add</button>
    </form>

</div>
</body>
</html>