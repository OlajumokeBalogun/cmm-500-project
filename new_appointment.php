<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-appointment">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-4">
			<div class="form-group">
              <label for="" class="control-label">Patient name</label>
              <select class="form-control form-control-sm select2" name="Patient_name">
              	<option></option>
              	<?php 
              	$patient = $conn->query("SELECT *,concat(Firstname,' ',Lastname) as name FROM patient  order by concat(Firstname,' ',Lastname) asc ");
              	while($row= $patient->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['name'] ?>" <?php echo isset($Patient_Id) && $Patient_Id == $row['Patient_Id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
			</div>
          	<div class="col-md-4">
				<div class="form-group">
					<label for="">Status</label>
					<select name="status" id="status" class="custom-select custom-select-sm">
						<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
						<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Hold</option>
						<option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label for="" class="control-label">Doctor's name</label>
              <select class="form-control form-control-sm select2" name="doctor_name">
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
              <label for="" class="control-label">Appointment Date</label>
              <input type="date" class="form-control form-control-sm" name="appointment_date" >
          </div>
		  </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Appointment Time</label>
              <input type="time" class="form-control form-control-sm"  name="appointment_time" >
            </div>
          </div>
		</div>
        <div class="row">
        	
           <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Staff name Scheduling Appointment</label>
              <select class="form-control form-control-sm select2" name="staff_scheduling">
              	<option></option>
              	<?php 
              $users = $conn->query("SELECT *,concat(firstname,' ',	lastname) as name FROM users order by concat(firstname,' ',	lastname) asc ");
              	while($row= $users->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($id) && $id== $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
      
         
        </div>
		
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-appointment">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=appointment'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$('#manage-appointment').submit(function(e){
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