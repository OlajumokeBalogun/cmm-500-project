<?php
include'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Drug_name= sanitizeInput($_POST["Drug_name"]);
    $Drug_desc = sanitizeInput($_POST["Drug_desc"]);
    
    $Drug_id = intval($_POST["Drug_id"]); 
    
    $stmt = $conn->prepare("UPDATE drug SET  Drug_name=?, Drug_desc=? WHERE Drug_id=?");
    $stmt->bind_param("ssi", $Drug_name, $Drug_desc, $Drug_id);

    if ($stmt->execute()) {
        echo "<script>
		alert('Drug records updated successfully.');
		setTimeout(function() {
			window.location.href = 'index.php?page=drugs';
		}, 200); // 1000 milliseconds = 3 seconds
	</script>";
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

?>

<!-- HTML Edit Form -->
<form action="" method="post">
    <input type="hidden" name="Drug_id" value="<?php echo $row["Drug_id"]; ?>">

    <div class="row">
        <div class="col-md-4 border-right">
            <div class="form-group">
                <label for="" class="control-label">Drug name</label>
                <input type="text" name="Drug_name" class="form-control form-control-sm" value="<?php echo $row["Drug_name"]; ?>" required>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="" class="control-label">Drug desc</label>
        <input type="text" name="Drug_desc" class="summernote form-control" value="<?php echo $row["Drug_desc"]; ?>" required>
    </div>
    
    <hr>
    <div class="col-lg-12 text-right justify-content-center d-flex">
        <button type="submit" class="btn btn-primary mr-2">Save</button>
        <button class="btn btn-secondary" type="button" onclick="location.href =  'baola.php?page=drugs'">Cancel</button>
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


//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE