<?php
session_start();
include('config.php');


// Fetch all categories from the database
$categoriesQuery = "SELECT id, name FROM categories";
$categoriesResult = mysqli_query($conn, $categoriesQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Plant Store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .jumbotron {
            height: 500px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./imgs/main-image.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
    
        .jumbotron h1 {
            font-size: 3rem;
        }
    
        .jumbotron p {
            font-size: 1.5rem;
        }
    </style>
    

</head>
<body>

<?php
include('navbar.php');
?>

<div class="jumbotron jumbotron-fluid">
    <div class="container text-center">
        <h1 class="display-4">Explore Our Green Oasis</h1>
        <p class="lead">Discover a diverse collection of exquisite plants to bring nature into your space.</p>
        <a href="login.php" class="btn btn-success btn-lg">Browse Plants</a>
    </div>
</div>


<div class="container mt-4 mb-5">
    <h2>Search Plants</h2>

    <form action="" method="GET">
        <div class="form-group">
            <label for="category">Select Category:</label>
            <select class="form-control" name="category">
                <option value="">All Categories</option>
                <?php
                while ($row = mysqli_fetch_assoc($categoriesResult)) {
                    $selected = (isset($_GET['category']) && $_GET['category'] == $row['id']) ? 'selected' : '';
                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="keyword">Search by Plant Name:</label>
            <input type="text" class="form-control" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
        </div>

        <input type="submit" class="btn btn-primary" value="Search">
    </form>

<h2>Available Plants</h2>

<?php
$whereClause = '';
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];
    $whereClause .= "AND p.CategoryID = $category";
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
    $whereClause .= " AND p.Name LIKE '%$keyword%'";
}

$plantsQuery = "SELECT p.PlantID, p.Name, c.name AS CategoryName, p.Price, p.ImageURL, p.Description
                FROM plants p
                INNER JOIN categories c ON p.CategoryID = c.id
                WHERE 1 $whereClause";
$plantsResult = mysqli_query($conn, $plantsQuery);

if (mysqli_num_rows($plantsResult) > 0) {
    echo '<div class="container">';
    echo '<div class="row">';

    while ($row = mysqli_fetch_assoc($plantsResult)) {
        echo '<div class="col-md-4">';
        echo '<div class="card mt-3">';
        echo '<img class="card-img-top" src="./admin/' . $row['ImageURL'] . '" alt="' . $row['Name'] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['Name'] . '</h5>';
        echo '<p class="card-text">' . $row['Description'] . '</p>';
        echo '<p class="card-text">Category: ' . $row['CategoryName'] . '</p>';
        echo '<p class="card-text">Price: ' . $row['Price'] . '</p>';
        echo '<a href="login.php" class="btn btn-primary">Buy</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
} else {
    echo '<p>No plants found for the selected category and keyword.</p>';
}

?>

</div>


<footer class="mt-5 py-3 bg-light">
    <div class="container text-center">
        <p>&copy; 2023 Rm-Plant Store. All rights reserved.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script></body>
</html>
