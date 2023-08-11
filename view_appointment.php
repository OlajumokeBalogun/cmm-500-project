<?php
include ('db_connect.php');




if (isset($_GET["Appointment_id"])) {
    $appointment_id= intval($_GET["Appointment_id"]);

    $sql = "SELECT * FROM appointment WHERE Appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
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
    <input type="hidden" name="appointment_id" value="<?php echo $row["Appointment_id"]; ?>">
   
    <div class="row">
					<div class="col-md-2">
							<label for="" class="control-label">Patient name</label>
							<div><?php echo $row["Patient_name"]; ?></div>
						
						
							<label for="" class="control-label">Status</label>
							
							<div>
							<?php echo $row["status"]; ?>
							</div>
							
						
						
							<label for="" class="control-label">Doctor name</label>
							<div>
							<?php echo $row["doctor_name"]; ?>
							</div>
					</div>
							<div class="col-md-2">
							<label for="" class="control-label">Appointment date</label>
							<div>
							<?php echo $row["Appointment_date"]; ?>
							</div>
							

                            <div class="form-group">
							<label for="" class="control-label">Staff scheduling</label>
							<div>
							<?php echo $row["staff_scheduling"]; ?>
					</div>		
					</div>			

						
						
						
						
					
					
						
						
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=appointment'">Cancel</button>
				</div>

    
</form>

