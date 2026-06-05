<?php
include('config.php');

session_start();

// Check if user is logged in
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

$user_id = $_SESSION["id"];

// Fetch user details from the database
$userQuery = "SELECT id, username, email, age FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $userQuery);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fetched_id, $username, $email, $age);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_age = $_POST['age'];

    $updateQuery = "UPDATE users SET username = '$new_username', email = '$new_email', age = $new_age WHERE id = $user_id";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Profile updated successfully.";
        $username = $new_username;
        $email = $new_email;
        $age = $new_age;
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    // Update password if provided
    $new_password = $_POST['new_password'];
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE users SET password = "YOUR_OWN_API_KEY" WHERE id = $user_id";
        if (mysqli_query($conn, $updatePasswordQuery)) {
            echo "Password updated successfully.";
        } else {
            echo "Error updating password: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php
include('navbar.php');
?>

<div class="container mt-4">
    <h2>Update Profile</h2>

    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" name="age" value="<?php echo $age; ?>" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" class="form-control" name="new_password">
        </div>

        <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
    </form>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

