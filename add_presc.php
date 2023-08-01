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
    // Step 2: Sanitize the form data
    $Patient_name = sanitizeInput($_POST["Patient_name"]);
    $Staff_name = sanitizeInput($_POST["Staff_name"]);
    $doctorNote = sanitizeInput($_POST["Doctor_note"]);
    $prescriptionStatus = sanitizeInput($_POST["prescription_status"]);
    $drugName = sanitizeInput($_POST["Drug_name"]);

    // Step 3: Use prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO prescription (Patient_name, Staff_name, Doctor_Note, prescription_Status, Drug_Name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss",  $Patient_name, $Staff_name, $doctorNote, $prescriptionStatus, $drugName);

    if ($stmt->execute()) {
        header("Location: index.php?page=prescription"); 
        exit();
    } else {
        // Insertion failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

function sanitizeInput($data)
{
    // Remove whitespace and strip HTML tags
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>