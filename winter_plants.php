<?php
// Database connection information
include('config.php');

// SQL query to retrieve plants with category "Winter"
$sql = "SELECT p.PlantID, p.Name, p.Price, p.ImageURL, p.Description
        FROM plants p
        INNER JOIN categories c ON p.CategoryID = c.id
        WHERE c.name = 'Winter'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Winter Plants</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container mt-4">
    <h2>Winter Plants</h2>

    <?php
    $counter = 0;
    if ($result->num_rows > 0) {
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            if ($counter % 3 == 0 && $counter != 0) {
                echo '</div><div class="row">';
            }
            ?>
            <!-- Bootstrap card for each plant -->
            <div class="col-md-4 mb-3">
                <div class="card" style="max-width: 100%;">
                    <img src="./admin/<?php echo $row["ImageURL"]; ?>" class="card-img-top" alt="Plant Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["Name"]; ?></h5>
                        <p class="card-text">Price: $<?php echo $row["Price"]; ?></p>
                        <p class="card-text"><?php echo $row["Description"]; ?></p>
                        <a href="login.php" class="btn btn-primary">Buy</a>
                    </div>
                </div>
            </div>
            <?php
            $counter++;
        }
        echo '</div>';
    } else {
        echo "No plants found in the 'Winter' category.";
    }

    $conn->close();
    ?>
</div>

<!-- Add Bootstrap JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
