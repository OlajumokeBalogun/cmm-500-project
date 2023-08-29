<?php
// session_manager.php

// Start the session
session_start();

// Knock Knock!..who is here??
if (isset($_SESSION['id'])) {
    //When last did you come here?
    if (isset($_SESSION['last_activity_time'])) {
        // Let me set the inactivity threshold 
        $inactive_threshold = 1 * 60; // one minute

        // Calculating the time elapsed since the last activity
        $time_elapsed = time() - $_SESSION['last_activity_time'];

        // How long have you been quiet?
        if ($time_elapsed > $inactive_threshold) {
            // Destroy the session and log out the user.you are too busy for this session.please leave..
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
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE