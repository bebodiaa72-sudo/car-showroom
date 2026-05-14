<?php
include "config/db.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$query = "
    SELECT cars.*,
    (SELECT COUNT(*) FROM orders WHERE orders.car_id = cars.id AND orders.payment_status != 'cancelled') AS is_booked
    FROM cars
    WHERE 1=1
";

if($search != '') {
    $search_safe = $conn->real_escape_string($search);
    $query .= " AND (cars.name LIKE '%$search_safe%' OR cars.brand LIKE '%$search_safe%')";
}

if($filter == 'available') {
    $query .= " HAVING is_booked = 0";
} elseif($filter == 'booked') {
    $query .= " HAVING is_booked > 0";
} elseif($filter == 'price_asc') {
    $query .= " ORDER BY cars.price ASC";
} elseif($filter == 'price_desc') {
    $query .= " ORDER BY cars.price DESC";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showroom - LUXURY</title>
    <link rel="stylesheet" href="assets/css/style.css">
        <link rel="icon" type="image/png" href="assets/images/logo.jpeg">

    <style>
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .search-bar input {
            flex: 1;
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #444;
            background: rgba(255,255,255,0.05);
            color: white;
            font-size: 14px;
            min-width: 200px;
        }

        .search-bar input::placeholder { color: #aaa; }

        .search-bar select {
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #444;
            background: rgba(255,255,255,0.05);
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .search-bar select option { background: #1a1a4e; }

        .search-bar button {
            padding: 10px 20px;
            border-radius: 8px;
            background: linear-gradient(135deg, #4a6cf7, #a855f7);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .search-bar button:hover { opacity: 0.85; }

        .results-count {
            color: #aaa;
            font-size: 13px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body class="body2">

<?php include "header.php"; ?>

<div class="container2">

    <h1>Our Cars</h1>
    <p>Explore our luxury collection</p>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'already_booked'): ?>
        <div style="background:#f8d7da; color:#842029; padding:12px 20px; border-radius:8px; margin-bottom:16px;">
            ❌ Sorry, this car is already booked!
        </div>
    <?php endif; ?>

    <form method="GET" class="search-bar">
        <input 
            type="text" 
            name="search" 
            placeholder="Search by name or brand..." 
            value="<?php echo htmlspecialchars($search); ?>"
        >
        <select name="filter">
            <option value="">All Cars</option>
            <option value="available" <?php echo $filter == 'available' ? 'selected' : ''; ?>>Available Only</option>
            <option value="booked"    <?php echo $filter == 'booked'    ? 'selected' : ''; ?>>Booked Only</option>
            <option value="price_asc" <?php echo $filter == 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
            <option value="price_desc"<?php echo $filter == 'price_desc'? 'selected' : ''; ?>>Price: High to Low</option>
        </select>

        <button type="submit">Search</button>
        
        <?php if($search != '' || $filter != ''): ?>
            <a href="showroom.php" style="padding:10px 16px; color:#aaa; text-decoration:none; border:1px solid #444; border-radius:8px;">
                Clear
            </a>
        <?php endif; ?>
    </form>

    <p class="results-count"><?php echo $result->num_rows; ?> car(s) found</p>

    <div class="brands">

        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="brand">

                <div class="logo-box">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                </div>

                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['brand']; ?></p>
                <p class="price">$<?php echo $row['price']; ?></p>

                <?php if($row['is_booked'] > 0): ?>
                    <button class="btn" style="background:#666; cursor:not-allowed;" disabled>
                        Already Booked
                    </button>
                <?php else: ?>
                    <a href="car_details.php?id=<?php echo $row['id']; ?>">
                        <button class="btn">View Details</button>
                    </a>
                <?php endif; ?>

            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align:center; padding:40px; color:#aaa; width:100%;">
                <p>No cars found 😔</p>
                <a href="showroom.php" style="color:#4a6cf7;">Clear Search</a>
            </div>
        <?php endif; ?>

    </div>

    <a href="index.php">
        <button class="btn">Back Home</button>
    </a>

</div>

<script src="assets/JS/main.js"></script>

</body>
</html>