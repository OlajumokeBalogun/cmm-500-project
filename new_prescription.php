<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
session_start();

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="add_presc.php" method="post" >

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
		<div class="col-md-6">
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
			<div class="col-md-6">
				<div class="form-group">
				<label for="" class="control-label">Doctor's name</label>
              <select class="form-control form-control-sm select2" name="Staff_name">
              	<option></option>
              	<?php 
              	$users = $conn->query("SELECT *,concat(	firstname,' ',	lastname) as name FROM users order by concat(firstname,' ',	lastname) asc ");
              	while($row= $users->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['name'] ?>" <?php echo isset($id) && $id== $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
				</div>
			</div>
			</div>
		<div class="row">
          <div class="col-md-6">
		  <div class="form-group">
              <label for="" class="control-label">Doctor's notes</label>
              <textarea cols="30" rows="10" class="summernote form-control" autocomplete="off" name="Doctor_note" ></textarea>
            </div>
          </div>

		  <div class="col-md-6">
				<div class="form-group">
					<label for="">Prescription Status</label>
					<select name="prescription_status" id="prescription_status" class="custom-select custom-select-sm">
						<option value="Collected"  selected >Collected</option>
						<option value="Awaiting Collection" >Awaiting Collection</option>
						
					</select>
				</div>   
			</div>
		</div>
		
		<div class="col-md-6">
				<div class="form-group">
				<label for="" class="control-label">Drug name</label>
              <select class="form-control form-control-sm select2" name="Drug_name">
              	<option></option>
              	<?php 
              	$drug = $conn->query("SELECT * FROM drug");
              	while($row= $drug->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['Drug_name'] ?>" <?php echo isset($id) && $id== $row['Drug_name'] ? "selected" : '' ?>><?php echo ucwords($row['Drug_name']) ?></option>
              	<?php endwhile; ?>
              </select>
				</div>
			</div>
			
		
       
			<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
				<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=prescription'">Cancel</button>
				</div>
        </form>
    	</div>
    	
	</div>
</div>
<script>
	$('#manage-prescription').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_prescription',
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
						location.href = 'index.php?page=prescription'
					},2000)
				}
			}
		})
	})
</script>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE