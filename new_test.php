<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-test">

        <input type="hidden" name="Test_id" value="<?php echo isset($id) ? $id : '' ?>">
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
              <select class="form-control form-control-sm select2" name="id">
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
              <label for="" class="control-label">Test Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?>">
            </div>
          </div>

		  <div class="col-md-6">
				<div class="form-group">
				<label for="" class="control-label">Patient name</label>
              <select class="form-control form-control-sm select2" name="Patient_name">
              	<option></option>
              	<?php 
              	$patient = $conn->query("SELECT *,concat(	firstname,' ',	lastname) as name FROM patient order by concat(firstname,' ',	lastname) asc ");
              	while($row= $patient->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['Patient_Id'] ?>" <?php echo isset($id) && $id== $row['Patient_Id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
				</div>
			</div>
			
		


		  </div>

		  <div class="col-md-6">
		  <div class="form-group">
              <label for="" class="control-label">Test results</label>
              <textarea cols="30" rows="10" class="form-control form-control-sm" autocomplete="off" name="start_date" ></textarea>
            </div>
          </div>

	
       
        	
         
      
         
   
		
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
    		</div>
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