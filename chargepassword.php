<!-- change_password.php -->
<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Retrieve the logged-in username
$username = $_SESSION['username'];

// Simulating updating the password in the database
function update_password($username, $new_password) {
    global $registered_users;
    $registered_users[$username]['password'] = $new_password;
    $registered_users[$username]['first_login'] = false;
}

// Redirect to the dashboard after changing the password
function redirect_to_dashboard() {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];

    if (is_strong_password($new_password)) {
        update_password($username, $new_password);
        redirect_to_dashboard();
    } else {
        echo 'Password does not meet the required strength criteria. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <h1>Change Password</h1>
    <form method="post" action="change_password.php">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <br>
        <input type="submit" value="Change Password">
    </form>
</body>
</html>
