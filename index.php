<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="assets/images/logo.jpeg">

    <meta name="description" content="Car Showroom website for exploring luxury, sports, and modern cars with detailed information and easy booking experience.">
    <meta name="keywords" content="car showroom, cars, luxury cars, sports cars, vehicle booking, معرض سيارات, سيارات حديثة">
    
    <title>LUXURY</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="body2">

        <?php include "header.php"; ?>

        <div class="receipt">
            <div class="upper">
                <div class="container">
                    <div class="klam">
                        <h1>immediate receipt</h1>
                        <p>ONLY IN OUR SHOWROOM</p>
                    </div>
                    <img src="assets/images/pexels-maria-geller-801267-2127039.jpg" alt="our new model" height="250px">
                </div>
                <h2>BMW M8 2026</h2>
            </div>
        </div>
    </div>

    <div class="find">
        <h3>Find your dream car</h3>
        <div class="boxes">
            <div class="box">
                <i class="fa-solid fa-car"></i>
                <p>Browse Our Cars</p>
                <a href="showroom.php">
                    <button class="btn">Find out more</button>
                </a>
            </div>
            <div class="box">
                <i class="fa-regular fa-message"></i>
                <p>Contact a Dealer</p>
                <a href="contact.php">
                    <button class="btn">Find out more</button>
                </a>
            </div>
        </div>
    </div>

    <div class="new porsche">
        <h2>PORSCHE 911 GT3 RS 2026</h2>
        <div class="buttons">
            <a href="showroom.php"><button class="btn">Request for Offer</button></a>
            <a href="showroom.php"><button class="btn a">Learn more</button></a>
        </div>
    </div>

    <div class="new lamborghini">
        <h2>Lamborghini Veneno Roadster 2026</h2>
        <div class="buttons">
            <a href="showroom.php"><button class="btn">Request for Offer</button></a>
            <a href="showroom.php"><button class="btn a">Learn more</button></a>
        </div>
    </div>

    <footer class="main-footer">
        <p>&copy; <span id="year">2023</span> LUXURY Car Showroom. All rights reserved.</p>
    </footer>

    <script src="assets/JS/main.js"></script>
</body>
</html>