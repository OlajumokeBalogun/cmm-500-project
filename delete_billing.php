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
    $id = isset($_GET["Billing_id"]) ? sanitize_input($_GET["Billing_id"]) : '';

    if ($action === "delete_billing") {
       
        $sql = "DELETE FROM billing WHERE Billing_id  = '$id'";
    } 
     else {
        echo "Invalid action.";
        exit();
    }
    if ($conn->query($sql) === TRUE) {
        
        echo "<script>
                alert('billing record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'index.php?page=billing';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    } else {
        
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>