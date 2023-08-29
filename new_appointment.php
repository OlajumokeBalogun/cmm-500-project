<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="add_appoint.php" method="post">

			<div class="col-md-4">
			<div class="form-group">
              <label for="" class="control-label">Patient_id</label>
              <select class="form-control form-control-sm select2" name="Patient_Id">
              	<option></option>
              	<?php 
              	$patient = $conn->query("SELECT *,concat(Firstname,' ',Lastname) as name FROM patient  order by concat(Firstname,' ',Lastname) asc ");
              	while($row= $patient->fetch_assoc()):
              	?>
              <option value="<?php echo $row['Patient_Id'] ?>" ><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
			</div>
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
              <option value="<?php echo $row['name'] ?>" ><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
			</div>
          	<div class="col-md-4">
				<div class="form-group">
					<label for="">Status</label>
					<select name="status" id="status" class="custom-select custom-select-sm">
						<option value="Pending" >Pending</option>
						<option value="On-Hold" >On-Hold</option>
						<option value="Done" >Done</option>
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
              	<option value="<?php echo $row['name'] ?>" ><?php echo ucwords($row['name']) ?></option>
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
              	<option value="<?php echo $row['name'] ?>" <?php echo isset($id) && $id== $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
      
         
        </div>
		<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'baola.php?page=appointment'">Cancel</button>
				</div>
        </form>
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
						location.href = 'baola.php?page=appointment'
					},2000)
				}
			}
		})
	})
</script>

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE