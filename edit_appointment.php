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
    $Patient_name= sanitizeInput($_POST["Patient_name"]);
    $status = sanitizeInput($_POST["status"]);
    $doctor_name= sanitizeInput($_POST["doctor_name"]);
    $appointment_date= sanitizeInput($_POST["appointment_date"]);
	$appointment_time= sanitizeInput($_POST["appointment_time"]);
	$staff_scheduling= sanitizeInput($_POST["staff_scheduling"]);
    
    $appointment_id= intval($_GET["appointment_id"]);
    
    $stmt = $conn->prepare("UPDATE appointment SET  Patient_name=?, status=?, doctor_name=?, appointment_date=? ,appointment_time=?,staff_scheduling=?  WHERE appointment_id=?");
    $stmt->bind_param("ssssssi", $status, $Amount, $doctor_name, $appointment_date,  $appointment_time,$staff_scheduling,$appointment_id);

    if ($stmt->execute()) {
        echo "Record updated. <a href='./index.php?page=appointment' role='button'> Go back to appointment</a>";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}


if (isset($_GET["appointment_id"])) {
    $appointment_id= intval($_GET["appointment_id"]);

    $sql = "SELECT * FROM appointment WHERE appointment_id = ?";
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
    <input type="hidden" name="appointment_id" value="<?php echo $row["appointment_id"]; ?>">

    <div class="row">
					<div class="col-md-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">Patient Name</label>
							<select class="form-control form-control-sm select2" name="Patient_name">
              	<option></option>
              	<?php 
              	$patient = $conn->query("SELECT *,concat(Firstname,' ',Lastname) as name FROM patient  order by concat(Firstname,' ',Lastname) asc ");
              	while($row= $patient->fetch_assoc()):
              	?>
              	<option value="<?php echo $row["status"]; ?>"></option>
              	<?php endwhile; ?>
              </select>
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
							<input type="date" name="appointment_date" class="form-control form-control-sm" value="<?php echo $row["appointment_date"]; ?>" required >
						</div>
						
						<div class="form-group">
							<label for="" class="control-label">Appointment time</label>
							<input type="time" name="appointment_time" class="form-control form-control-sm" value="<?php echo $row["appointment_time"]; ?>" required >
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


