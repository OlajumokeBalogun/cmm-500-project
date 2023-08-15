<?php
include'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Patient_name= sanitizeInput($_POST["Patient_name"]);
    $status = sanitizeInput($_POST["status"]);
    $doctor_name= sanitizeInput($_POST["doctor_name"]);
    $appointment_date= sanitizeInput($_POST["appointment_date"]);
	$appointment_time= sanitizeInput($_POST["appointment_time"]);
	$staff_scheduling= sanitizeInput($_POST["staff_scheduling"]);
    
    $appointment_id= intval($_GET["Appointment_id"]);
    
    $stmt = $conn->prepare("UPDATE appointment SET  Patient_name=?, status=?, doctor_name=?, Appointment_date=? ,Appointment_time=?,staff_scheduling=?  WHERE Appointment_id=?");
    $stmt->bind_param("ssssssi", $Patient_name, $status,  $doctor_name, $appointment_date,  $appointment_time,$staff_scheduling,$appointment_id);

    if ($stmt->execute()) {
        echo "<script>
				alert('Appointment record updated successfully.');
				setTimeout(function() {
					window.location.href = 'baola.php?page=appointment';
				}, 200); // 1000 milliseconds = 3 seconds
			</script>";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }
	
    $stmt->close();
}



if (isset($_GET["Appointment_id"])) {
    $appointment_id= intval($_GET["Appointment_id"]);

    $sql = "SELECT * FROM appointment WHERE Appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row= $result->fetch_assoc();
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
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" method="post">
    <input type="hidden" name="Appointment_id" value="<?php echo $row["Appointment_id"]; ?>">

    <div class="row">
					<div class="col-md-4 border-right">
					<div class="form-group">
							<label for="" class="control-label">Patient name</label>
							<input type="text" name="Patient_name" class="form-control form-control-sm" value="<?php echo $row["Patient_name"]; ?>" required >
						</div>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Status</label>
							<input type="text" name="status" class="form-control form-control-sm" value="<?php echo $row["status"]; ?>" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Doctor name</label>
							<input type="text" name="doctor_name" class="form-control form-control-sm" value="<?php echo $row["doctor_name"]; ?>" required >
						</div>
					
						<div class="form-group">
							<label for="" class="control-label">Appointment date</label>
							<input type="date" name="appointment_date" class="form-control form-control-sm" value="<?php echo $row["Appointment_date"]; ?>" required >
						</div>
						
						<div class="form-group">
							<label for="" class="control-label">Appointment time</label>
							<input type="time" name="appointment_time" class="form-control form-control-sm" value="<?php echo $row["Appointment_time"]; ?>" required >
						</div>
						
						<div class="form-group">
							<label for="" class="control-label">Staff scheduling</label>
							
							<input type="text" name="staff_scheduling" class="form-control form-control-sm" value="<?php echo $row["staff_scheduling"]; ?>" required >
						</div>
						
					</div>
					
					
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=appointment'">Cancel</button>
				</div>

    
</form>
</div>


