<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Delete plant if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM plants WHERE PlantID = $delete_id";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Plant deleted successfully.";
    } else {
        echo "Error deleting plant: " . mysqli_error($conn);
    }
}

// Fetch plants with category names from the database
$plantsQuery = "SELECT p.PlantID, p.Name, c.name AS CategoryName, p.Price, p.ImageURL, p.Description
                FROM plants p
                INNER JOIN categories c ON p.CategoryID = c.id";
$plantsResult = mysqli_query($conn, $plantsQuery);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Plants</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-4">
    <h2>Manage Plants</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>PlantID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($plantsResult)) {
                echo '<tr>';
                echo '<td>' . $row['PlantID'] . '</td>';
                echo '<td><img src="' . $row['ImageURL'] . '" width="100" height="100"></td>';
                echo '<td>' . $row['Name'] . '</td>';
                echo '<td>' . $row['CategoryName'] . '</td>';
                echo '<td>' . $row['Price'] . '</td>';
                echo '<td>' . $row['Description'] . '</td>';
                echo '<td>';
                echo '<a href="edit_plant.php?id=' . $row['PlantID'] . '" class="btn btn-primary">Edit</a> ';
                echo '<a href="?delete_id=' . $row['PlantID'] . '" class="btn btn-danger">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Bootstrap JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
