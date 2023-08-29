<?php
//starting the database
include'db_connect.php';

//checking to see the method of request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //sanitizing the inputs into the database
    $Patient_Id = $_POST["Patient_Id"];
    $patientName = sanitizeInput($_POST["Patient_name"]);
    $status = sanitizeInput($_POST["status"]);
    $doctor_name = sanitizeInput($_POST["doctor_name"]);
    $appointmentDate = $_POST["appointment_date"];// no need to sanitize date and time
    $appointmentTime = $_POST["appointment_time"];
    $staffScheduling = sanitizeInput($_POST["staff_scheduling"]);
  
//prepping the sql statement
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointment WHERE appointment_date = ? AND appointment_time = ?");
    $stmt->bind_param("ss", $appointmentDate, $appointmentTime);
    $stmt->execute();
    $stmt->bind_result($appointmentCount);
    $stmt->fetch();
    $stmt->close();

    //if the appointment already exists....this takes care of finding it out
    if ($appointmentCount > 0) {
        echo "<script>
            alert('Appointment with the same date and time already exists. Please choose a different date and time..');
            setTimeout(function() {
                window.location.href = 'baola.php?page=new_appointment';
            }, 200); // the message will display for  1000 milliseconds = 2 seconds
        </script>";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO appointment (Patient_Id, Patient_name, status, doctor_name, appointment_date, appointment_time, staff_scheduling) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $Patient_Id, $patientName, $status, $doctor_name, $appointmentDate, $appointmentTime, $staffScheduling);

        if ($stmt->execute()) {
            echo "<script>
            alert('Appointment record updated successfully.');
            setTimeout(function() {
                window.location.href = 'baola.php?page=appointment';
            }, 200); // the message will display for  1000 milliseconds = 2 seconds
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
    // Removing the  whitespace and strip HTML tags
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE