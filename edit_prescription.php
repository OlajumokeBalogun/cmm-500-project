<?php
include ('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Patient_name= sanitizeInput($_POST["Patient_name"]);
    $Staff_name = sanitizeInput($_POST["Staff_name"]);
    $Drug_name = sanitizeInput($_POST["Drug_name"]);
    $prescription_status = sanitizeInput($_POST["prescription_status"]);
    $Doctor_note = sanitizeInput($_POST["Doctor_note"]);
   
    
    $Prescription_id= intval($_POST["Prescription_id"]); 
    
    $stmt = $conn->prepare("UPDATE prescription SET	Patient_name=?, Staff_name=?,Drug_name=? ,prescription_status=?, Doctor_note=? WHERE Prescription_id=?");
    $stmt->bind_param("sssssi", $Patient_name, $Staff_name, $Drug_name,$prescription_status,$Doctor_note,$Prescription_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Prescription  record updated successfully!!.');
        setTimeout(function() {
            window.location.href = 'index.php?page=prescription';
        }, 200); // 1000 milliseconds = 3 seconds
    </script>";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }
   
    $stmt->close();
}

   
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

?>

<!-- HTML Edit Form -->
<form action="" method="post">
    <input type="hidden" name="Prescription_id" value="<?php echo $row["Prescription_id"]; ?>">

    <div class="row">
        <div class="col-md-4 border-right">
            <div class="form-group">
                <label for="" class="control-label">Patient_name</label>
                <input type="text" name="Patient_name" class="form-control form-control-sm" value="<?php echo $row["Patient_name"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Drug_name</label>
                <input type="text" name="Drug_name" class="form-control form-control-sm" value="<?php echo $row["Drug_name"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Staff_name</label>
                <input type="text" name="Staff_name" class="form-control form-control-sm" value="<?php echo $row["Staff_name"]; ?>" required>
            </div>
            <div class="form-group">
              <label for="" class="control-label">Doctor's notes</label>
              <input type="text" name="Doctor_note" class="form-control form-control-sm" value="<?php echo $row["Doctor_note"]; ?>" required>
            </div>
            <div class="form-group">
					<label for="">Prescription Status</label>
					<select name="prescription_status" id="prescription_status" class="custom-select custom-select-sm">
						<option value="Collected"  selected >Collected</option>
						<option value="Awaiting Collection" >Awaiting Collection</option>
						
					</select>
        </div>
    </div>
    
    
    
    <hr>
    <div class="col-lg-12 text-right justify-content-center d-flex">
        <button type="submit" class="btn btn-primary mr-2">Save</button>
        <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=prescription'">Cancel</button>
    </div>
</form>

<!-- Add the following JavaScript code for the toast notification -->
<script>
    function showToast(message) {
        const toastContainer = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerText = message;
        toastContainer.appendChild(toast);
        setTimeout(function () {
            toastContainer.removeChild(toast);
        }, 3000);
    }
</script>

