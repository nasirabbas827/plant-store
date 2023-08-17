<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $imagePath = "uploads/" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    // Insert the plant data into the database
    $query = "INSERT INTO plants (Name, CategoryID, Price, ImageURL, Description)
              VALUES ('$name', $category, $price, '$imagePath', '$description')";

    if (mysqli_query($conn, $query)) {
        echo "Plant added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch categories from the categories table
$categoryQuery = "SELECT id, name FROM categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Plant</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php
include('admin_navbar.php');
?>
    <div class="container mt-4 mb-5">
        <h2>Add Plant</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" name="category" required>
                    <?php
                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" name="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Add Plant</button>
            <a href="view_plants.php" class="btn btn-secondary">View Plants</a>
        </form>
    </div>
    
    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
