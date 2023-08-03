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
<form action="" method="post">
    <input type="hidden" name="Drug_id" value="<?php echo $row["Drug_id"]; ?>">
   
    <div class="row">
					<div class="col- d-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">Drug name</label>
							<div><?php echo $row["Drug_name"]; ?></div>
						</div>
						<div>
							<label for="" class="control-label">Drug desc</label>
							
							<div>
							<?php echo $row["Drug_desc"]; ?>
							</div>
							
						</div>
						
						
						
						
					</div>
					
						
						
						

					
					
					
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=drugs'">Cancel</button>
				</div>
</div>
    
</form></div>
