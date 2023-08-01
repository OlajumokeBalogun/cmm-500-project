<?php
// Step 1: Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kikedb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"]) && $_POST["action"] === "delete_patient") {
        $patientId = intval($_POST["Patient_Id"]);

        // Step 2: Use prepared statement to delete user by Patient Id
        $stmt = $conn->prepare("DELETE FROM patient WHERE Patient_Id = ?");
        $stmt->bind_param("i", $patientId);

        if ($stmt->execute()) {
            // Deletion successful
            echo "1";
        } else {
            // Deletion failed
            echo "0";
        }

        $stmt->close();
    }
}

$conn->close();
?>
