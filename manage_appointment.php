<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM Appointment where appointment_id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-appointment">	
		<input type="hidden" name="id" value="<?php echo isset($meta['appointment_id']) ? $meta['appointment_id']: '' ?>">
		<div class="form-group">
			<label for="patient_name">Patient Name</label>
			<input type="text" name="patient_name" id="patient_name" class="form-control" value="<?php echo isset($meta['patient_name']) ? $meta['patient_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="status">Status</label>
			<input type="text" name="status" id="status" class="form-control" value="<?php echo isset($meta['status']) ? $meta['status']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="doctor_name">Doctor Name</label>
			<input type="text" name="doctor_name" id="doctor_name" class="form-control" value="<?php echo isset($meta['doctor_name']) ? $meta['doctor_name']: '' ?>" required  >
		</div>
		<div class="form-group">
			<label for="appointment_date">Appointment Date</label>
			<input type="date" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo isset($meta['appointment_date']) ? $meta['appointment_date']: '' ?>" required >
			
		</div>
		<div class="form-group">
			<label for="appointment_date">Appointment Time</label>
			<input type="time" name="appointment_time" id="appointment_time" class="form-control" value="<?php echo isset($meta['appointment_time']) ? $meta['appointment_time']: '' ?>" required >
			
		</div>
		<div class="form-group">
			<label for="staff_scheduling">Staff name Scheduling Appointment</label>
			<input type="text" name="staff_scheduling" id="staff_scheduling" class="form-control" value="<?php echo isset($meta['staff_scheduling']) ? $meta['staff_scheduling']: '' ?>" required >
			
		</div>
		
		

	</form>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
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
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}
			}
		})
	})

</script>