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
    $Test_name = sanitizeInput($_POST["Test_name"]);
    $Test_results = sanitizeInput($_POST["Test_results"]);
    
    

    // Step 3: Use prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO test (Patient_name, Staff_name, Test_name, Test_results) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",  $Patient_name, $Staff_name, $Test_name, $Test_results);

    if ($stmt->execute()) {
        
        echo "<script>
		alert(' new test  record created successfully!!.');
		setTimeout(function() {
			window.location.href = 'index.php?page=test';
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