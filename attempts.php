<?php
session_start();
include ('db_connect.php');
function login($email, $password)
{
    // Perform authentication here
    // Replace the following line with your actual authentication logic.
    $authenticated = ($email === "testuser" && $password === "testpassword");

    if ($authenticated) {
        // Successful login, reset login attempts and redirect to the dashboard.
        $_SESSION["email"] = $email;
        reset_login_attempts($email);
        header("Location: index.php");
        exit;
    } else {
        // Failed login, increment login attempts.
        $login_attempts = increment_login_attempts($email);

        // Check if login attempts reach the limit (e.g., 3 failed attempts).
        $max_attempts = 3;
        if ($login_attempts >= $max_attempts) {
            // Lock the account and display a message to the user.
            lock_account($email);
            echo "Account locked. Please contact support.";
            exit;
        } else {
            // Show an error message to the user for failed attempts.
            echo "Invalid username or password. Attempt $login_attempts of $max_attempts.";
        }
    }
}

function increment_login_attempts($email)
{
    // Replace database_connection_code with your actual database connection code.
    include ('db_connect.php');

    $email = mysqli_real_escape_string($conn, $email);

    // Check if the user already has login attempts recorded.
    $query = "SELECT attempts FROM login_attempts WHERE username = '$email' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // User exists in the login_attempts table.
        $row = $result->fetch_assoc();
        $attempts = $row['attempts'] + 1;
        $query = "UPDATE login_attempts SET attempts = $attempts WHERE email = '$email'";
        $conn->query($query);
    } else {
        // User does not exist in the login_attempts table, create a new entry.
        $query = "INSERT INTO login_attempts (email, attempts) VALUES ('$email', 1)";
        $conn->query($query);
        $attempts = 1;
    }

    $conn->close();

    return $attempts;
}

function reset_login_attempts($email)
{
    // Reset login attempts for the given user.
    // Replace database_connection_code with your actual database connection code.
    include ('db_connect.php');

    $email = mysqli_real_escape_string($conn, $email);
    $query = "UPDATE login_attempts SET attempts = 0 WHERE email = '$email'";
    $conn->query($query);
    $conn->close();
}

function lock_account($email)
{
    // Lock the account when login attempts reach the limit.
    // You can add additional logic here if needed.
}

