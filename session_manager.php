<?php
// session_manager.php

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    // Check if last activity time is set
    if (isset($_SESSION['last_activity_time'])) {
        // Define the inactivity threshold 
        $inactive_threshold = 1 * 60; // one minute

        // Calculate the time elapsed since the last activity
        $time_elapsed = time() - $_SESSION['last_activity_time'];

        // Check if the user has been inactive for too long
        if ($time_elapsed > $inactive_threshold) {
            // Destroy the session and log out the user
            session_unset();
            session_destroy();
            header("Location: index.php"); // Redirect to login page or any other page
            exit;
        }
    }
}

// Update last activity time on each request
$_SESSION['last_activity_time']=time();
?>