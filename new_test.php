<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="add_test.php" method="post" >

        
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
              <label for="" class="control-label">Test name</label>
			  <input type="text" name="Test_name" id="Test_name" class="form-control" >
			</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
				<label for="" class="control-label">Staff name</label>
              <select class="form-control form-control-sm select2" name="Staff_name">
              	<option></option>
              	<?php 
              	$users = $conn->query("SELECT *,concat(	firstname,' ',	lastname) as name FROM users order by concat(firstname,' ',	lastname) asc ");
              	while($row= $users->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($id) && $id== $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
				</div>
			</div>
			</div>
		
			<div class="row">
			

		  <div class="col-md-6">
				<div class="form-group">
				<label for="" class="control-label">Patient name</label>
              <select class="form-control form-control-sm select2" name="Patient_name">
              	<option></option>
              	<?php 
              	$patient = $conn->query("SELECT *,concat(	firstname,' ',	lastname) as name FROM patient order by concat(firstname,' ',	lastname) asc ");
              	while($row= $patient->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['name'] ?>" <?php echo isset($id) && $id== $row['Patient_Id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
				</div>
			</div>
			
		


		  </div>

		  <div class="col-md-6">
		  <div class="form-group">
              <label for="" class="control-label">Test results</label>
              <textarea cols="30" rows="10" class="summernote form-control" autocomplete="off" name="Test_results" ></textarea>
            </div>
          </div>
   
		  <hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=test'">Cancel</button>
				</div>
        </form>
    	</div>
    	
	</div>
</div>
<script>
	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_appointment',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=appointment'
					},2000)
				}
			}
		})
	})
</script>