<?php
include'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 2: Sanitize the form data
   
    $Drug_name = sanitizeInput($_POST["Drug_name"]);
    $Drug_desc = sanitizeInput($_POST["Drug_desc"]);
    

    // Step 3: Use prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO drug (Drug_name, Drug_desc) VALUES (?, ?)");
    $stmt->bind_param("ss", $Drug_name, $Drug_desc);

    if ($stmt->execute()) {
		  
        echo "<script>
                alert(' Drug Record added  successfully.');
                setTimeout(function() {
                    window.location.href = 'baola.php?page=drugs';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
        exit();
    } else {
        // Insertion failed
        echo "Error: " . $conn->error;
    }

    $stmt->close();
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
include 'header.php' 
?>


<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" method="post">

        
		<div class="row">
		<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Drug Name</label>
              <input type="text" class="form-control form-control-sm" autocomplete="off" name="Drug_name" >
            </div>
          </div>
          <div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label for="" class="control-label">Description</label>
					<textarea name="Drug_desc" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($Drug_desc) ? $Drug_desc : '' ?>
					</textarea>
				</div>
			</div>
		</div>
		  
			
        
		
		</div>
		<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=drugs'">Cancel</button>
				</div>
        </form>
    	</div>
    	
	</div>
</div>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE