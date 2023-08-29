<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM test where Test_id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-test">	
		<input type="hidden" name="id" value="<?php echo isset($meta['Test_id']) ? $meta['Test_id']: '' ?>">
		<div class="form-group">
			<label for="patient_name">Patient Name</label>
			<input type="text" name="patient_name" id="patient_name" class="form-control" value="<?php echo isset($meta['patient_name']) ? $meta['patient_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="patient_name">Staff Name</label>
			<input type="text" name="Staff_name" id="Staff_name" class="form-control" value="<?php echo isset($meta['Staff_name']) ? $meta['Staff_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="patient_name">Test Name</label>
			<input type="text" name="Test_name" id="Test_name" class="form-control" value="<?php echo isset($meta['Test_name']) ? $meta['Test_name']: '' ?>" required>
		</div>

		<div class="form-group">
              <label for="" class="control-label">Test results</label>
              <textarea cols="30" rows="10" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($meta['Test_results']) ? $meta['Test_results']: '' ?>"></textarea>
            </div>

		<div class="form-group">
			<label for="Billing_date">Test date</label>
			<input type="date" name="Test_date" id="Test_date" class="form-control" value="<?php echo isset($meta['Test_date']) ? $meta['Test_date']: '' ?>" required >
			
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
	$('#manage-test').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_test',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					alert_toast("New test successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Test already exist</div>')
					end_load()
				}
			}
		})
	})

</script>

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE