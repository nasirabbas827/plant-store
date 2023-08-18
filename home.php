<?php
include('config.php');

session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Fetch user details from the database
$sql = "SELECT id, username, email, age FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fetched_id, $username, $email, $age);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch all categories from the database
$categoriesQuery = "SELECT id, name FROM categories";
$categoriesResult = mysqli_query($conn, $categoriesQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Plants Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php
include('navbar.php');
?>

<div class="container mt-4 mb-5">
    <h2>Welcome, <?php echo $username; ?>!</h2>

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
        echo '<a href="buy_form.php?plant_id=' . $row['PlantID'] . '" class="btn btn-primary">Buy</a>';
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

</body>
</html>
