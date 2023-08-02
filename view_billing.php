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




if (isset($_GET["Billing_id"])) {
    $Billing_id= intval($_GET["Billing_id"]);

    $sql = "SELECT * FROM billing WHERE Billing_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Billing_id);
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
    <input type="hidden" name="Billing_id" value="<?php echo $row["Billing_id"]; ?>">
   
    <div class="row">
					<div class="col- d-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">Patient name</label>
							<div><?php echo $row["Patient_name"]; ?></div>
						</div>
						<div>
							<label for="" class="control-label">Amount</label>
							
							<div>
							<?php echo $row["Amount"]; ?>
							</div>
							
						</div>
						<div class="form-group">
							<label for="" class="control-label">Payment Status</label>
							<div>
							<?php echo $row["Payment_status"]; ?>
							</div>
							
						</div>
					
						<div class="form-group">
							<label for="" class="control-label">Payment mode</label>
							<div>
							<?php echo $row["Payment_mode"]; ?>
							</div>
							
						</div>
						
                        <div class="form-group">
							<label for="" class="control-label">Billing_date</label>
							<div>
							<?php echo $row["Billing_date"]; ?>
							</div>
							
						</div>
						
						
					</div>
					
					
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=billing'">Cancel</button>
				</div>
</div>
    
</form></div>

