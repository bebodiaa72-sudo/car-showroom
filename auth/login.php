<?php
session_start();

include "../config/db.php";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])){

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            if($row['role'] == 'admin'){
                header("Location: ../dashboard/index.php");
            } else {   
                header("Location: ../index.php");
            }

        } else {
            echo "<p style='color:red;text-align:center;'>Wrong Password</p>";
        }

    } else {
        echo "<p style='color:red;text-align:center;'>User not found</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Login</title>
</head>

<body class="body2">

<div class="container2">

    <h1>Login</h1>
    
    <a href="../index.php">
        <button class="btn">← Back Home</button>
    </a>
    
    <form method="POST" class="buy">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button class="btn" name="login">Login</button>

    </form>

    <p class="auth-link">
        Don't have account?
        <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>