<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Update order status in the database
    $updateQuery = "UPDATE orders SET Status = '$new_status' WHERE OrderID = $order_id";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
}

// Fetch orders from the database
$ordersQuery = "SELECT o.OrderID, u.username AS Username, p.Name AS PlantName, o.Quantity, o.TotalAmount, o.Status, o.PaymentMode, o.OrderDate
                FROM orders o
                INNER JOIN users u ON o.UserID = u.id
                INNER JOIN plants p ON o.PlantID = p.PlantID
                ORDER BY o.OrderDate DESC";
$ordersResult = mysqli_query($conn, $ordersQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Order Management</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-4">
    <h2>Admin - Order Management</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Plant Name</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment Mode</th>
                <th>Order Date</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($ordersResult)) {
                echo '<tr>';
                echo '<td>' . $row['OrderID'] . '</td>';
                echo '<td>' . $row['Username'] . '</td>';
                echo '<td>' . $row['PlantName'] . '</td>';
                echo '<td>' . $row['Quantity'] . '</td>';
                echo '<td>' . $row['TotalAmount'] . '</td>';
                echo '<td>' . $row['Status'] . '</td>';
                echo '<td>' . $row['PaymentMode'] . '</td>';
                echo '<td>' . $row['OrderDate'] . '</td>';
                echo '<td>
                        <form action="" method="POST">
                            <input type="hidden" name="order_id" value="' . $row['OrderID'] . '">
                            <select class="form-control" name="new_status">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Packed">Packed</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Fulfilled">Fulfilled</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2" name="update_status">Update</button>
                        </form>
                    </td>';
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

