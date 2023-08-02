<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM Prescription where Prescription_id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-prescription">	
		<input type="hidden" name="id" value="<?php echo isset($meta['Prescription_id ']) ? $meta['Prescription_id ']: '' ?>">
		<div class="form-group">
			<label for="patient_name">Patient Name</label>
			<input type="text" name="patient_name" id="patient_name" class="form-control" value="<?php echo isset($meta['patient_name']) ? $meta['patient_name']: '' ?>" required>
		</div>
		
		<div class="form-group">
			<label for="doctor_name">Staff Name</label>
			<input type="text" name="Staff_name" id="Staff_name" class="form-control" value="<?php echo isset($meta['Staff_name']) ? $meta['Staff_name']: '' ?>" required  >
		</div>
		<div class="form-group">
			<label for="doctor_name">Drug Name</label>
			<input type="text" name="Drug_name" id="Drug_name" class="form-control" value="<?php echo isset($meta['Drug_name']) ? $meta['Drug_name']: '' ?>" required  >
		</div>

		
		<div class="form-group">
			<label for="staff_scheduling">Doctor's Note</label>
            <textarea cols="30" rows="10" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($Doctor_note) ? date("Y-m-d",strtotime($Doctor_note)) : '' ?>"></textarea>
			
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