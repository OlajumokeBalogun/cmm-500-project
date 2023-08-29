<?php
include'db_connect.php';



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

    
   
    <div class="row">
					<div class="col-md-4">
						
							<label for="" class="control-label">First Name</label>
							<div><?php echo $row["Firstname"]; ?></div>
						
						
							<label for="" class="control-label">Middle Name</label>
							
							<div>
							<?php echo $row["Middlename"]; ?>
							</div>
							
						
							<label for="" class="control-label">Last Name</label>
							<div>
							<?php echo $row["Lastname"]; ?>
							</div>
							
						
					
						
							<label for="" class="control-label">Date of Birth</label>
							<div>
							<?php echo $row["dob"]; ?>
							</div>
		
					</div>
					
					<div class="col-md-4">
						
							<label class="control-label">Email</label>
							<div>
							<?php echo $row["email"]; ?>
							</div>
							
							<small id="#msg"></small>
						
						
						
							<label for="" class="control-label">Age</label>
							<div>
							<?php echo $row["age"]; ?>
							</div>
							
						
						
							<label class="control-label">Bloodgroup</label>
							<div>
							<?php echo $row["bloodgroup"]; ?>
							</div>
							
							<small id="#msg"></small>
						
						
							<label class="control-label">Weight</label>
							<div>
							<?php echo $row["weight"]; ?>
							</div>
							
							<small id="#msg"></small>
						
					</div>

					
					
					<div class="col-md-4">
						
							<label class="control-label">Height</label>
							<div>
							<?php echo $row["height"]; ?>
							
							</div>
							<small id="#msg"></small>
						
						
						
					
							<label for="" class="control-label">Address</label>
							<div>
							<?php echo $row["address"]; ?>
						</div>
						
							<label for="" class="control-label">Gender</label>
							<div>
							<?php echo $row["gender"]; ?>
							</div>
							
					
						
					
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=patient'">Cancel</button>
				</div>

    
</div>

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE