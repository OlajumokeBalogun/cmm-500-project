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




if (isset($_GET["Test_id"])) {
    $Test_id= intval($_GET["Test_id"]);

    $sql = "SELECT * FROM test WHERE Test_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Test_id);
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

function sanitizeInput($data)
{
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>

<!-- HTML Edit Form -->

   
    <div class="row">
					<div class="col-md-4">
						
							<label for="" class="control-label">Patient name</label>
							<div><?php echo $row["Patient_name"]; ?></div>
						
						
							<label for="" class="control-label">Staff_name</label>
							
							<div>
							<?php echo $row["Staff_name"]; ?>
							</div>
							
						
						
							<label for="" class="control-label">Test_name</label>
							<div>
							<?php echo $row["Test_name"]; ?>
							</div>
							</div>
						
							<div class="col-md-4">
					
							<label for="" class="control-label">Test results</label>
							<div>
							<?php echo $row["Test_results"]; ?>
							</div>
							
							
						
                     
							<label for="" class="control-label">Test date</label>
							<div>
							<?php echo $row["Test_date"]; ?>
							</div>
							
						</div>
						
						
				
					
					
				
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=test'">Cancel</button>
				</div>
				</div>
				
