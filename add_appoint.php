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
    
    $patientName = sanitizeInput($_POST["Patient_name"]);
    $status = sanitizeInput($_POST["status"]);
    $doctor_name = sanitizeInput($_POST["doctor_name"]);
    $appointmentDate = $_POST["appointment_date"];
    $appointmentTime = $_POST["appointment_time"];
    $staffScheduling = sanitizeInput($_POST["staff_scheduling"]);

    
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointment WHERE appointment_date = ? AND appointment_time = ?");
    $stmt->bind_param("ss", $appointmentDate, $appointmentTime);
    $stmt->execute();
    $stmt->bind_result($appointmentCount);
    $stmt->fetch();
    $stmt->close();

    if ($appointmentCount > 0) {
        
        echo "Appointment with the same date and time already exists. Please choose a different date and time.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO appointment (Patient_name, status, doctor_name, appointment_date, appointment_time, staff_scheduling) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $patientName, $status, $doctor_name, $appointmentDate, $appointmentTime, $staffScheduling);

        if ($stmt->execute()) {
            header("Location: index.php?page=appointment"); 
        exit();
        } else {
            // Insertion failed
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
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
