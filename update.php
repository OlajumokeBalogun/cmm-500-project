<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kikedb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Assuming the form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Drug_id = $_POST["Drug_id"];
    $Drug_name = $_POST["Drug_name"];
    $Drug_desc = $_POST["Drug_desc"];
    
    // Assuming you have database update and insert queries here
    // Replace the placeholders with your actual database operations
    $stmt = $conn->prepare("UPDATE drug SET  Drug_name=?, Drug_desc=? WHERE Drug_id=?");
    $stmt->bind_param("ssi", $Drug_name, $Drug_desc, $Drug_id);
    
    // Uncomment the following lines and replace the placeholders with your actual database operations
  
    if ($stmt->execute()) {
        // Display success message using PHP
        echo "Record updated successfully";
        // Show toast notification using JavaScript
        echo "<script>showToast('Record updated successfully');</script>";
    } else {
        echo "Error updating record: " ;
    }
    
      
if (isset($_GET["Drug_id"])) {
    $Drug_id= intval($_GET["Drug_id"]);

    $sql = "SELECT * FROM drug WHERE Drug_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Drug_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit();
    }
    $stmt->close();
   
} else {
    echo "Invalid request.";
    exit();
}
    
    
    // After performing the update and insert operations, redirect the user back to drugs.php
    header("Location: index.php?page=drugs"); 
    exit();
}
?>
