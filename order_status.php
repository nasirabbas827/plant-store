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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Status</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php
include('navbar.php');
?>

<div class="container mt-4">

    <h2>Welcome, <?php echo $username; ?>!</h2>

    <h2>Your Order Status</h2>

    <?php
    // Fetch orders for the current user
    $ordersQuery = "SELECT o.OrderID, p.Name AS PlantName, o.Quantity, o.TotalAmount, o.Status, o.PaymentMode, o.OrderDate
                    FROM orders o
                    INNER JOIN plants p ON o.PlantID = p.PlantID
                    WHERE o.UserID = $user_id
                    ORDER BY o.OrderDate DESC";
    $ordersResult = mysqli_query($conn, $ordersQuery);

    if (mysqli_num_rows($ordersResult) > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th>Order ID</th>';
        echo '<th>Plant Name</th>';
        echo '<th>Quantity</th>';
        echo '<th>Total Amount</th>';
        echo '<th>Payment Mode</th>';
        echo '<th>Status</th>';
        echo '<th>Order Date</th>';
        echo '<th>Cancel Order</th>';
        echo '</tr>';
        echo '</thead>';

        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($ordersResult)) {
            echo '<tr>';
            echo '<td>' . $row['OrderID'] . '</td>';
            echo '<td>' . $row['PlantName'] . '</td>';
            echo '<td>' . $row['Quantity'] . '</td>';
            echo '<td>' . $row['TotalAmount'] . '</td>';
            echo '<td>' . $row['PaymentMode'] . '</td>';
            echo '<td>' . $row['Status'] . '</td>';
            echo '<td>' . $row['OrderDate'] . '</td>';
            echo '<td><a href="delete_order.php?order_id=' . $row['OrderID'] . '" class="btn btn-danger btn-sm">Cancel</a></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No orders found.</p>';
    }
    ?>

</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
