<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-billing">

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
							<label class="control-label">Amount</label>
							<input type="text" class="form-control form-control-sm" name="amount" required value="<?php echo isset($amount) ? $amount: '' ?>">
							<small id="#msg"></small>
						</div>
			</div>
			</div>

          	<div class="row" >
              <div class="col-md-6">
				<div class="form-group">
					<label for="">Payment Status</label>
					<select name="Payment_status" id="Payment_status" class="custom-select custom-select-sm">
						<option value="Paid" <?php echo isset($Payment_status) ? 'selected' : '' ?>>Paid</option>
						<option value="Due" <?php echo isset($Payment_status)  ? 'selected' : '' ?>>Due</option>
						<option value="Over due" <?php echo isset($Payment_status)  ? 'selected' : '' ?>>Over due</option>
                        <option value="Transaction Pending" <?php echo isset($Payment_status)  ? 'selected' : '' ?>>Transaction Pending</option>
					</select>
				</div>
            </div>

                <div class="col-md-6">
				<div class="form-group">
					<label for="">Payment Mode</label>
					<select name="Payment_mode" id="Payment_mode" class="custom-select custom-select-sm">
						<option value="cash" <?php echo isset($Payment_mode) ? 'selected' : '' ?>>cash</option>
						<option value="card/contactless" <?php echo isset($Payment_mode) ? 'selected' : '' ?>>card/contactless</option>
						<option value="bank transfer" <?php echo isset($Payment_mode)  ? 'selected' : '' ?>>bank transfer</option>
                        <option value="cheque" <?php echo isset($Payment_mode)  ? 'selected' : '' ?>>cheque</option>
					</select>
				</div>

			</div>
            </div>
			
			
		
         
		
		
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-billing">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=billing'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$('#manage-billing').submit(function(e){
		e.preventDefault()
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
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=billing'
					},2000)
				}
			}
		})
	})
</script>