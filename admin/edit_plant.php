<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $plantID = $_GET['id'];

    // Fetch plant details for the provided ID
    $plantQuery = "SELECT * FROM plants WHERE PlantID = $plantID";
    $plantResult = mysqli_query($conn, $plantQuery);
    $plantData = mysqli_fetch_assoc($plantResult);

    if (!$plantData) {
        echo "Plant not found.";
        exit;
    }

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        // Update plant data in the database
        $updateQuery = "UPDATE plants SET
                        Name = '$name',
                        CategoryID = $category,
                        Price = $price,
                        Description = '$description'
                        WHERE PlantID = $plantID";

        if (mysqli_query($conn, $updateQuery)) {
            echo "Plant updated successfully.";
        } else {
            echo "Error updating plant: " . mysqli_error($conn);
        }
    }

    // Fetch categories from the categories table
    $categoryQuery = "SELECT id, name FROM categories";
    $categoryResult = mysqli_query($conn, $categoryQuery);
} else {
    echo "Plant ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Plant</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-4 mb-5">
    <h2>Edit Plant</h2>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo $plantData['Name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" name="category" required>
                <?php
                while ($row = mysqli_fetch_assoc($categoryResult)) {
                    $selected = ($row['id'] == $plantData['CategoryID']) ? 'selected' : '';
                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" name="price" step="0.01" value="<?php echo $plantData['Price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" rows="4" required><?php echo $plantData['Description']; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Update Plant</button>
    </form>
</div>

<!-- Add Bootstrap JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

