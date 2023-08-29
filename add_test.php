<?php
//starting the database connection and the session manager
include('session_manager.php');
include'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //sanitizing the form data
    $Patient_name = sanitizeInput($_POST["Patient_name"]);
    $Staff_name = sanitizeInput($_POST["Staff_name"]);
    $Test_name = sanitizeInput($_POST["Test_name"]);
    $Test_results = sanitizeInput($_POST["Test_results"]);
    $Test = sanitizeInput($_POST["id"]);

    // using prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO test (Patient_name, Staff_name, Test_name, Test_results) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",  $Patient_name, $Staff_name, $Test_name, $Test_results);

    if ($stmt->execute()) {
        
        echo "<script>
		alert(' new test  record created successfully!!.');
		setTimeout(function() {
			window.location.href = 'baola.php?page=test';
		}, 200); //display the message for  1000 milliseconds = 2 seconds
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

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE