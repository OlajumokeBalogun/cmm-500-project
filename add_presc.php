<?php
include'db_connect.php';

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
        echo "<script>
        alert('New prescription created successfully!!.');
        setTimeout(function() {
            window.location.href = 'index.php?page=prescription';
        }, 200); // 1000 milliseconds = 3 seconds
    </script>";
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