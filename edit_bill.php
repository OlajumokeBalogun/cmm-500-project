<?php
include'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Patient_name= sanitizeInput($_POST["Patient_name"]);
    $Amount = sanitizeInput($_POST["Amount"]);
    $Payment_mode= sanitizeInput($_POST["Payment_mode"]);
    $Payment_status = sanitizeInput($_POST["Payment_status"]);
    
    $Billing_id= intval($_GET["Billing_id"]);
    
    $stmt = $conn->prepare("UPDATE billing SET  Patient_name=?, Amount=?, Payment_mode=?, Payment_status=?   WHERE Billing_id=?");
    $stmt->bind_param("ssssi", $Patient_name, $Amount, $Payment_mode, $Payment_status,  $Billing_id);

    if ($stmt->execute()) {
        echo "<script>
		alert('patient record updated successfully.');
		setTimeout(function() {
			window.location.href = 'baola.php?page=billing';
		}, 200); // 1000 milliseconds = 3 seconds
	</script>";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}


if (isset($_GET["Billing_id"])) {
    $Billing_id= intval($_GET["Billing_id"]);

    $sql = "SELECT * FROM billing WHERE Billing_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Billing_id);
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
    <input type="hidden" name="Billing_id" value="<?php echo $row["Billing_id"]; ?>">

    <div class="row">
					<div class="col-md-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">Patient name</label>
							<input type="text" name="Patient_name" class="form-control form-control-sm" value="<?php echo $row["Patient_name"]; ?>" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Amount</label>
							<input type="text" name="Amount" class="form-control form-control-sm" value="<?php echo $row["Amount"]; ?>" required >
						</div>
						<div class="form-group">
							<label for="" class="control-label">Payment mode</label>
							<input type="text" name="Payment_mode" class="form-control form-control-sm" value="<?php echo $row["Payment_mode"]; ?>" required >
						</div>

                       

					
						<div class="form-group">
							<label for="" class="control-label">Payment status</label>
							<select name="Payment_status" id="Payment_status" class="custom-select custom-select-sm" required>
						<option value="Paid" >Paid</option>
						<option value="Due" >Due</option>
						<option value="Over due" >Over due</option>
                        <option value="Transaction Pending">Transaction Pending</option>
					</select>
						</div>
						
						
						
					</div>
					
					</div>

					
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=billing'">Cancel</button>
				</div>

    
</form>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE