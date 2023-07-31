<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-4 border-right">
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Middle Name</label>
							<input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($middlename) ? $middlename : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
						</div>
					
						<div class="form-group">
							<label for="" class="control-label">Date of Birth</label>
							<input type="date" name="dob" class="form-control form-control-sm" required value="<?php echo isset($dob) ? $dob : '' ?>">
						</div>
						
						
						
					</div>
					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Age</label>
							<input type="number" name="age" class="form-control form-control-sm" required value="<?php echo isset($age) ? $age : '' ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Bloodgroup</label>
							<input type="text" class="form-control form-control-sm" name="bloodgroup" required value="<?php echo isset($bloodgroup) ? $bloodgroup: '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Weight</label>
							<input type="text" class="form-control form-control-sm" name="weight" required value="<?php echo isset($weight) ? $weight: '' ?>">
							<small id="#msg"></small>
						</div>
					</div>

					<div class="col-md-4">
						
						<div class="form-group">
							<label class="control-label">Height</label>
							<input type="text" class="form-control form-control-sm" name="height" required value="<?php echo isset($height) ? $height : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Address</label>
							<input type="text" name="address" class="form-control form-control-sm" required value="<?php echo isset($address) ? $address : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Gender</label>
							<select name="gender" id="gender" class="custom-select custom-select-sm">
								<option value="Male" <?php echo isset($type) && $type == 'Male' ? 'selected' : '' ?>>Male</option>
								<option value="Female" <?php echo isset($type) && $type == 'Female' ? 'selected' : '' ?>>Female</option>
								<option value="Prefer not to say" <?php echo isset($type) && $type == 'Prefer not to say' ? 'selected' : '' ?>>Prefer not to say</option>
							</select>
						</div>
						
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
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
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_user').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('[name="password"]').val() != '' && $('[name="cpass"]').val() != ''){
			if($('#pass_match').attr('data-status') != 1){
				if($("[name='password']").val() !=''){
					$('[name="password"],[name="cpass"]').addClass("border-danger")
					end_load()
					return false;
				}
			}
		}
		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=user_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>