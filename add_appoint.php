<?php
include ('db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Patient_Id = $_POST["Patient_Id"];
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
        echo "<script>
            alert('Appointment with the same date and time already exists. Please choose a different date and time..');
            setTimeout(function() {
                window.location.href = 'index.php?page=new_appointment';
            }, 200); // 1000 milliseconds = 3 seconds
        </script>";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO appointment (Patient_Id, Patient_name, status, doctor_name, appointment_date, appointment_time, staff_scheduling) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $Patient_Id, $patientName, $status, $doctor_name, $appointmentDate, $appointmentTime, $staffScheduling);

        if ($stmt->execute()) {
            echo "<script>
            alert('Appointment record updated successfully.');
            setTimeout(function() {
                window.location.href = 'index.php?page=appointment';
            }, 200); // 1000 milliseconds = 3 seconds
        </script>";
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
