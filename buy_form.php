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

// Get the selected plant information based on the provided PlantID
if (isset($_GET['plant_id']) && is_numeric($_GET['plant_id'])) {
    $plant_id = $_GET['plant_id'];
    
    $plantQuery = "SELECT p.PlantID, p.Name, c.name AS CategoryName, p.Price, p.ImageURL, p.Description
                FROM plants p
                INNER JOIN categories c ON p.CategoryID = c.id
                WHERE p.PlantID = $plant_id";
    $plantResult = mysqli_query($conn, $plantQuery);
    
    if ($plantRow = mysqli_fetch_assoc($plantResult)) {
        $selectedPlant = $plantRow;
    } else {
        echo "Plant not found.";
        exit;
    }
} else {
    echo "Invalid Plant ID.";
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Extract form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $quantity = $_POST['quantity'];
    $totalAmount = $selectedPlant['Price'] * $quantity;

    // Insert order into the database
    $insertQuery = "INSERT INTO orders (UserID, PlantID, Quantity, TotalAmount, Name, Phone, Address, Status, PaymentMode)
                    VALUES ($user_id, $plant_id, $quantity, $totalAmount, '$name', '$phone', '$address', 'Pending', 'Cash on Delivery')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Plant</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php
include('navbar.php');
?>

<div class="container mt-4 mb-5">

    <h3>Selected Plant Details:</h3>
    <div class="row">
        <div class="col-md-4">
            <img src="./admin/<?php echo $selectedPlant['ImageURL']; ?>" class="img-fluid" alt="<?php echo $selectedPlant['Name']; ?>">
        </div>
        <div class="col-md-8">
            <p><strong>Name:</strong> <?php echo $selectedPlant['Name']; ?></p>
            <p><strong>Category:</strong> <?php echo $selectedPlant['CategoryName']; ?></p>
            <p><strong>Price:</strong> <?php echo $selectedPlant['Price']; ?></p>
            <p><strong>Description:</strong> <?php echo $selectedPlant['Description']; ?></p>
        </div>
    </div>

    <h2 class="mt-4">Buy Plant: <?php echo $selectedPlant['Name']; ?></h2>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Delivery Address:</label>
            <textarea class="form-control" name="address" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" name="quantity" id="quantityInput" min="1" value="1" required onchange="calculateTotalPrice()">
        </div>
        <div class="form-group">
            <label for="payment_mode">Payment Mode:</label>
            <select class="form-control" name="payment_mode">
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>
        </div>
        <div class="form-group">
            <strong>Total Price: <span id="totalPrice"><?php echo $selectedPlant['Price']; ?></span></strong>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Place Order</button>
    </form>

</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function calculateTotalPrice() {
    var quantity = document.getElementById("quantityInput").value;
    var unitPrice = <?php echo $selectedPlant['Price']; ?>;
    var totalPrice = quantity * unitPrice;

    document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);
}
</script>

</body>
</html>
