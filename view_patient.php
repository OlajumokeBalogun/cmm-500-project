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




if (isset($_GET["Patient_Id"])) {
    $Patient_Id= intval($_GET["Patient_Id"]);

    $sql = "SELECT * FROM patient WHERE Patient_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Patient_Id);
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
    <input type="hidden" name="Patient_Id" value="<?php echo $row["Patient_Id"]; ?>">
   
    <div class="row">
					<div class="col- d-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<div><?php echo $row["Firstname"]; ?></div>
						</div>
						<div
							<label for="" class="control-label">Middle Name</label>
							
							<div>
							<?php echo $row["Middlename"]; ?>
							</div>
							
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<div>
							<?php echo $row["Lastname"]; ?>
							</div>
							
						</div>
					
						<div class="form-group">
							<label for="" class="control-label">Date of Birth</label>
							<div>
							<?php echo $row["dob"]; ?>
							</div>
							
						</div>
						
						
						
					</div>
					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Email</label>
							<div>
							<?php echo $row["email"]; ?>
							</div>
							
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Age</label>
							<div>
							<?php echo $row["age"]; ?>
							</div>
							
						</div>
						<div class="form-group">
							<label class="control-label">Bloodgroup</label>
							<div>
							<?php echo $row["bloodgroup"]; ?>
							</div>
							
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Weight</label>
							<div>
							<?php echo $row["weight"]; ?>
							</div>
							
							<small id="#msg"></small>
						</div>
					</div>

					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Height</label>
							<div>
							<?php echo $row["height"]; ?>
							</div>
							
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Address</label>
							<div>
							<?php echo $row["address"]; ?>
							</div>
							
						</div>
						<div class="form-group">
							<label for="" class="control-label">Gender</label>
							<div>
							<?php echo $row["gender"]; ?>
							</div>
							
						</div>
						
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=patient'">Cancel</button>
				</div>

    
</form>
