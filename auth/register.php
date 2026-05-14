<?php
include "../config/db.php";

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users(username,email,password,role)
    VALUES('$username','$email','$password','user')");

    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Register</title>
</head>

<body class="body2">

<div class="container2">

    <h1>Register</h1>
    
    <a href="../index.php">
        <button class="btn">← Back Home</button>
    </a>
    
    <form method="POST" class="buy">

        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button class="btn" name="register">Register</button>

    </form>

    <p class="auth-link">
        Already have account?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>