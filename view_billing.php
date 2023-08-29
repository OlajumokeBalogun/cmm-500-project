<?php
include'db_connect.php';

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

    <div class="row">
					<div class="col-md-4">
							<label for="" class="control-label">Patient name</label>
							<div><?php echo $row["Patient_name"]; ?></div>
					
					
							<label for="" class="control-label">Amount</label>
							
							<div>
							<?php echo $row["Amount"]; ?>
							</div>
							
						
						
							<label for="" class="control-label">Payment Status</label>
							<div>
							<?php echo $row["Payment_status"]; ?>
							</div>
							</div>
						
							<div class="col-md-4">
						
							<label for="" class="control-label">Payment mode</label>
							<div>
							<?php echo $row["Payment_mode"]; ?>
							</div>
							
						
						
                       
							<label for="" class="control-label">Billing_date</label>
							<div>
							<?php echo $row["Billing_date"]; ?>
							</div>
							
						
						
						
					</div>
					</div>
					
					</div>
				
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=billing'">Cancel</button>
				</div>

				//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE