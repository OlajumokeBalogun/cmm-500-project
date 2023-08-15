<?php
include'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Firstname = sanitizeInput($_POST["Firstname"]);
    $Middlename= sanitizeInput($_POST["Middlename"]);
    $Lastname = sanitizeInput($_POST["Lastname"]);
    $dob = sanitizeInput($_POST["dob"]);
    $email = sanitizeInput($_POST["email"]);
    $age = intval($_POST["age"]);
    $bloodgroup = sanitizeInput($_POST["bloodgroup"]);
    $weight = sanitizeInput($_POST["weight"]);
    $height = sanitizeInput($_POST["height"]);
    $address = sanitizeInput($_POST["address"]);
    $gender = sanitizeInput($_POST["gender"]);

    $Patient_Id = intval($_POST["Patient_Id"]); 

    
    $stmt = $conn->prepare("UPDATE patient SET Firstname=?, Middlename=?, Lastname=?, dob=?, email=?,  age=?, bloodgroup=?, weight=?, height=?, address=?, gender=? WHERE Patient_Id=?");
    $stmt->bind_param("sssssisssssi", $Firstname, $Middlename, $Lastname, $dob, $email, $age, $bloodgroup, $weight, $height, $address, $gender, $Patient_Id);

    if ($stmt->execute()) {
		echo "<script>
		alert('patient record updated successfully.');
		setTimeout(function() {
			window.location.href = 'baola.php?page=patient';
		}, 200); // 1000 milliseconds = 3 seconds
	</script>";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
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
					<div class="col-md-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="Firstname" class="form-control form-control-sm" value="<?php echo $row["Firstname"]; ?>" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Middle Name</label>
							<input type="text" name="Middlename" class="form-control form-control-sm" value="<?php echo $row["Middlename"]; ?>" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<input type="text" name="Lastname" class="form-control form-control-sm" value="<?php echo $row["Lastname"]; ?>" required >
						</div>
					
						<div class="form-group">
							<label for="" class="control-label">Date of Birth</label>
							<input type="date" name="dob" class="form-control form-control-sm" value="<?php echo $row["dob"]; ?>" required >
						</div>
						
						
						
					</div>
					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" value="<?php echo $row["email"]; ?>" required >
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Age</label>
							<input type="number" name="age" class="form-control form-control-sm"  value="<?php echo $row["age"]; ?>" required >
						</div>
						<div class="form-group">
							<label class="control-label">Bloodgroup</label>
							<input type="text" class="form-control form-control-sm" name="bloodgroup" value="<?php echo $row["bloodgroup"]; ?>" required >
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Weight</label>
							<input type="text" class="form-control form-control-sm" name="weight" value="<?php echo $row["weight"]; ?>" required >
							<small id="#msg"></small>
						</div>
					</div>

					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Height</label>
							<input type="text" class="form-control form-control-sm" name="height" value="<?php echo $row["height"]; ?>" required >
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Address</label>
							<input type="text" name="address" class="form-control form-control-sm" value="<?php echo $row["address"]; ?>" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Gender</label>
							<select name="gender" id="gender" class="custom-select custom-select-sm" value="<?php echo $row["gender"]; ?>">
								<option value="Male"  selected>Male</option>
								<option value="Female" >Female</option>
								<option value="Prefer not to say">Prefer not to say</option>
							</select>
						</div>
						
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=patient'">Cancel</button>
				</div>

    
</form>
