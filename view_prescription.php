<?php
include'db_connect.php';
session_start();


if (isset($_GET["Prescription_id"])) {
    $Prescription_id= intval($_GET["Prescription_id"]);

    $sql = "SELECT * FROM prescription WHERE Prescription_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Prescription_id);
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
					<div class="col md-4">
						
							<label for="" class="control-label">Patient name</label>
							<div><?php echo $row["Patient_name"]; ?></div>
						
					
							<label for="" class="control-label">Staff name</label>
							
							<div>
							<?php echo $row["Staff_name"]; ?>
							</div>
							
					
							<label for="" class="control-label">Drug name</label>
							<div>
							<?php echo $row["Drug_name"]; ?>
							</div>
							</div>
							
							
							<div class="col md-4">
						
							<label for="" class="control-label">Prescription Status</label>
							<div>
							<?php echo $row["prescription_status"]; ?>
							</div>
							
							
							<label class="control-label">Doctor's note</label>
							<div>
							<?php echo $row["Doctor_note"]; ?>
							</div>
							
							<small id="#msg"></small>
					
					
							<label for="" class="control-label">Prescription date</label>
							<div>
							<?php echo $row["Prescription_date"]; ?>
							</div>
							
							</div>
							</div>
			
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=prescription'">Cancel</button>
				</div>
				

