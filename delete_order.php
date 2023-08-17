<?php
include('config.php');

if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Delete the order
    $deleteQuery = "DELETE FROM orders WHERE OrderID = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $order_id);
    
    if (mysqli_stmt_execute($deleteStmt)) {
        // Order deleted successfully, redirect back to the order status page
        header("Location: order_status.php");
        exit;
    } else {
        // Error deleting order
        echo "Error deleting order: " . mysqli_error($conn);
    }

    mysqli_stmt_close($deleteStmt);
} else {
    echo "Invalid order ID.";
}
?>
