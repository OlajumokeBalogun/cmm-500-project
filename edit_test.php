<?php

include ('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Patient_name = sanitizeInput($_POST["Patient_name"]);
    $Staff_name= sanitizeInput($_POST["Staff_name"]);
    $Test_name = sanitizeInput($_POST["Test_name"]);
    $Test_results= sanitizeInput($_POST["Test_results"]);
    
    $Test_id  = intval($_POST["Test_id"]); 

    
    $stmt = $conn->prepare("UPDATE test SET Patient_name=?, Staff_name=?, Test_name=?, Test_results=? WHERE Test_id =?");
    $stmt->bind_param("ssssi", $Patient_name, $Staff_name, $Test_name, $Test_results, $Test_id);

    if ($stmt->execute()) {
		echo "<script>
		alert('test  record updated successfully.');
		setTimeout(function() {
			window.location.href = 'index.php?page=test';
		}, 200); // 1000 milliseconds = 3 seconds
	</script>";
        exit();
    } else {
        // Update failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}


if (isset($_GET["Test_id"])) {
    $Test_id= intval($_GET["Test_id"]);

    $sql = "SELECT * FROM test WHERE Test_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Test_id);
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
<div class="card-body">
			<form action="" method="post" >

            <input type="hidden" name="Test_id" value="<?php echo $row["Test_id"]; ?>">
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
              <label for="" class="control-label">Test name</label>
			  <input type="text" name="Test_name" id="Test_name" class="form-control" value="<?php echo $row['Test_name'] ?>" >
			
			</div>
            </div>
			<div class="col-md-6">
			<div class="form-group">
              
			  <input type="text" name="Staff_name" id="Staff_name" class="form-control" value="<?php echo $row['Staff_name'] ?>" >
			
			</div>
            </div>
                </div>
			
                <div class="row">
                <div class="col-md-6">
			<div class="form-group">
              <label for="" class="control-label">Patient name</label>
			  <input type="text" name="Patient_name" id="Patient_name" class="form-control" value="<?php echo $row['Patient_name'] ?>" >
			
			</div>
            </div>
           
	
		  <div class="col-md-6">
		  <div class="form-group">
              <label for="" class="control-label">Test results</label>
              <input class="form-control" type="text" name="Test_results" id="Test_results" value="<?php echo $row['Test_results'] ?>">
             
            </div>
          </div>
          </div>
		  <hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=test'">Cancel</button>
				</div>
        </form>
    	</div>
