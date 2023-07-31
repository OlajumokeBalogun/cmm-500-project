<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM billing where Billing_id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-billing">	
		<input type="hidden" name="id" value="<?php echo isset($meta['Billing_id']) ? $meta['Billing_id']: '' ?>">
		<div class="form-group">
			<label for="patient_name">Patient Name</label>
			<input type="text" name="patient_name" id="patient_name" class="form-control" value="<?php echo isset($meta['patient_name']) ? $meta['patient_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="amount">Amount</label>
			<input type="text" name="amount" id="amount" class="form-control" value="<?php echo isset($meta['amount']) ? $meta['amount']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="Payment_mode">Payment mode</label>
			<input type="text" name="Payment_mode" id="Payment_mode" class="form-control" value="<?php echo isset($meta['Payment_mode']) ? $meta['Payment_mode']: '' ?>" required  >
		</div>
		<div class="form-group">
			<label for="Payment_status">Payment status</label>
			<input type="text" name="Payment_status" id="Payment_status" class="form-control" value="<?php echo isset($meta['Payment_status']) ? $meta['appointment_date']: '' ?>" required >
			
		</div>
		<div class="form-group">
			<label for="Billing_date">Billing date</label>
			<input type="date" name="Billing_date" id="Billing_date" class="form-control" value="<?php echo isset($meta['Billing_date']) ? $meta['Billing_date']: '' ?>" required >
			
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
			url:'ajax.php?action=save_billing',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					alert_toast("New billing successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Billing already exist</div>')
					end_load()
				}
			}
		})
	})

</script>