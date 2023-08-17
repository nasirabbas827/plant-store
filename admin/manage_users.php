<?php
include('config.php');

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Handle user deletion
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];

    // Delete user from the database
    $deleteQuery = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

// Fetch all users from the database
$usersQuery = "SELECT id, username, email, age FROM users";
$usersResult = mysqli_query($conn, $usersQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - User Management</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
include('admin_navbar.php');
?>

<div class="container mt-4">
    <h2>Admin - User Management</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Age</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($usersResult)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['age'] . '</td>';
                echo '<td><a href="?delete_id=' . $row['id'] . '">Delete</a></td>';
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
