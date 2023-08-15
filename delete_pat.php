<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = isset($_GET["action"]) ? sanitize_input($_GET["action"]) : '';
    $id = isset($_GET["id"]) ? sanitize_input($_GET["id"]) : '';

    if ($action === "delete_patient" && !empty($id)) {
        $id = mysqli_real_escape_string($conn, $id); // Escape input to prevent SQL injection
        $sql = "DELETE FROM patient WHERE Patient_Id = '$id'";
        
        if ($conn->query($sql)) {
            echo "
            <script>
                alert('Patient record deleted successfully.');
                window.location.href = 'baola.php?page=patient';
            </script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Invalid request.";
    }
}

// Sanitize user input to prevent SQL injection
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
