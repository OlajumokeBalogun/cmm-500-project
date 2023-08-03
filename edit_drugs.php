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
    $Drug_name= sanitizeInput($_POST["Drug_name"]);
    $Drug_desc = sanitizeInput($_POST["Drug_desc"]);
    
    $Drug_id = intval($_POST["Drug_id"]); 
    
    $stmt = $conn->prepare("UPDATE drug SET  Drug_name=?, Drug_desc=? WHERE Drug_id=?");
    $stmt->bind_param("ssi", $Drug_name, $Drug_desc, $Drug_id);

    if ($stmt->execute()) {
        echo "Record updated.";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}


if (isset($_GET["Drug_id"])) {
    $Drug_id= intval($_GET["Drug_id"]);

    $sql = "SELECT * FROM drug WHERE Drug_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Drug_id);
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
    <input type="hidden" name="Drug_id" value="<?php echo $row["Drug_id"]; ?>">

    <div class="row">
					<div class="col-md-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">Drug name</label>
							<input type="text" name="Drug_name" class="form-control form-control-sm" value="<?php echo $row["Drug_name"]; ?>" required >
						</div>
                        </div>
				</div>
                <div class="form-group">
              <label for="" class="control-label">Drug desc</label>
              <input type="text" name="Drug_desc" class="form-control form-control-sm" value="<?php echo $row["Drug_desc"]; ?>" required >
            </div>

				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2" onclick="location.href = 'edit_drugs.php?page=drugs'">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'edit_drugs.php?page=drugs'">Cancel</button>
				</div>

    
</form>
