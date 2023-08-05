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
    $amount = sanitizeInput($_POST["amount"]);
    $Payment_status = sanitizeInput($_POST["Payment_status"]);
    $Payment_mode = sanitizeInput($_POST["Payment_mode"]);
    

    // Step 3: Use prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO billing (Patient_name, amount, Payment_status, Payment_mode) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",  $Patient_name, $amount, $Payment_status, $Payment_mode);

    if ($stmt->execute()) {
        // Insertion successful
        echo "<script>
		alert('patient bill records added successfully!!.');
		setTimeout(function() {
			window.location.href = 'index.php?page=billing';
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