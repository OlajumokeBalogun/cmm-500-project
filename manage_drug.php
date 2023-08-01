<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM drug where Drug_id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-drug">	
		<input type="hidden" name="id" value="<?php echo isset($meta['Drug_id']) ? $meta['Drug_id']: '' ?>">
		<div class="form-group">
			<label for="patient_name">Drug Name</label>
			<input type="text" name="Drug_name" id="Drug_name" class="form-control" value="<?php echo isset($meta['Drug_name']) ? $meta['Drug_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="amount">Drug desc</label>
			<textarea cols="30" rows="10" class="form-control form-control-sm" autocomplete="off" name="Drug_desc" value="<?php echo isset($meta['Drug_desc']) ? $meta['Drug_desc']: '' ?> "></textarea>
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
	$('#manage-drug').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_drug',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					alert_toast("New drug successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Drug already exist</div>')
					end_load()
				}
			}
		})
	})

</script>