<?php
include'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 2: Sanitize the form data
    $firstname = sanitizeInput($_POST["firstname"]);
    $middlename = sanitizeInput($_POST["middlename"]);
    $lastname = sanitizeInput($_POST["lastname"]);
    $dob = sanitizeInput($_POST["dob"]);
    $email = sanitizeInput($_POST["email"]);
    $age = intval($_POST["age"]);
    $bloodgroup = sanitizeInput($_POST["bloodgroup"]);
    $weight = sanitizeInput($_POST["weight"]);
    $height = sanitizeInput($_POST["height"]);
    $address = sanitizeInput($_POST["address"]);
    $gender = sanitizeInput($_POST["gender"]);

    // Step 3: Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM patient WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($emailCount);
    $stmt->fetch();
    $stmt->close();

    if ($emailCount > 0) {
        // Email already exists, prompt the user to try another
        echo "Email already exists. Please try another email.";
    } else {
        // Step 4: Use prepared statements to insert data into the database
        $stmt = $conn->prepare("INSERT INTO patient (firstname, middlename, lastname, dob, email, age, bloodgroup, weight, height, address, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisssss", $firstname, $middlename, $lastname, $dob, $email, $age, $bloodgroup, $weight, $height, $address, $gender);

        if ($stmt->execute()) {
            echo "<script>
				alert('New patient record created successfully.');
				setTimeout(function() {
					window.location.href = 'baola.php?page=patient';
				}, 200); // 1000 milliseconds = 3 seconds
			</script>";
        exit();
        } else {
            // Insertion failed
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

function sanitizeInput($data)
{
    // Remove whitespace and strip HTML tags
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>



<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" method="post" >
				
				<div class="row">
					<div class="col-md-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="firstname" class="form-control form-control-sm" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Middle Name</label>
							<input type="text" name="middlename" class="form-control form-control-sm" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<input type="text" name="lastname" class="form-control form-control-sm" required >
						</div>
					
						<div class="form-group">
							<label for="" class="control-label">Date of Birth</label>
							<input type="date" name="dob" class="form-control form-control-sm" required >
						</div>
						
						
						
					</div>
					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" required >
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Age</label>
							<input type="number" name="age" class="form-control form-control-sm" required >
						</div>
						<div class="form-group">
							<label class="control-label">Bloodgroup</label>
							<input type="text" class="form-control form-control-sm" name="bloodgroup" required >
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Weight</label>
							<input type="text" class="form-control form-control-sm" name="weight" required >
							<small id="#msg"></small>
						</div>
					</div>

					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Height</label>
							<input type="text" class="form-control form-control-sm" name="height" required >
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Address</label>
							<input type="text" name="address" class="form-control form-control-sm" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Gender</label>
							<select name="gender" id="gender" class="custom-select custom-select-sm">
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
		</div>
	</div>
</div>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE