<!DOCTYPE html>
<html>
<head>
    <title>Password Change</title>
</head>
<body>
    <h2>Password Change</h2>
    <form action="update_password.php" method="post">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="confirm_new_password">Confirm New Password:</label>
        <input type="password" id="confirm_new_password" name="confirm_new_password" required><br>
        <input type="submit" value="Change Password">
    </form>
</body>
</html>