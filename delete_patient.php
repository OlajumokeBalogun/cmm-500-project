<?php

$conn = new mysqli('localhost','root','','kikedb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $action = isset($_GET["action"]) ? sanitize_input($_GET["action"]) : '';
    $id = isset($_GET["Patient_Id"]) ? sanitize_input($_GET["Patient_Id"]) : '';

    if ($action === "delete_patient") {
       
        $sql = "DELETE FROM patient WHERE Patient_Id  = '$id'";
    } 
     else {
        echo "Invalid action.";
        exit();
    }
    if ($conn->query($sql) === TRUE) {
        
        echo "<script>
                alert('Record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'index.php?page=patient';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    } else {
        
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>