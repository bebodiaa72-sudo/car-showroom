<?php

include "config/db.php";

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM cars WHERE id=$id");

$car = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car['name']; ?></title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="body2">

<?php include "header.php"; ?>

<div class="container2">

    <div class="brand" style="max-width: 900px; width:100%;">

        <div class="logo-box" style="height:450px;">

            <img 
                src="<?php echo $car['image']; ?>" 
                alt="<?php echo $car['name']; ?>"
                style="
                    width:100%;
                    height:100%;
                    object-fit:cover;
                "
            >

        </div>

        <h1 style="
            color:white;
            margin-top:20px;
            text-align:center;
        ">
            <?php echo $car['name']; ?>
        </h1>

        <p style="
            text-align:center;
            font-size:20px;
            color:#aaa;
        ">
            <?php echo $car['brand']; ?>
        </p>

        <h2 style="
            text-align:center;
            color:#00ff88;
        ">
            $<?php echo $car['price']; ?>
        </h2>

        <p style="
            color:white;
            line-height:1.8;
            margin-top:20px;
            text-align:center;
        ">
            <?php echo $car['description']; ?>
        </p>

        <div style="
            display:flex;
            justify-content:center;
            margin-top:30px;
        ">

            <a href="payment.php?id=<?php echo $car['id']; ?>">

                <button class="btn">
                    Buy Now
                </button>

            </a>

        </div>

    </div>

</div>

<script src="assets/JS/main.js"></script>

</body>
</html>