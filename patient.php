<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_patient"><i class="fa fa-plus"></i> Add New patient</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="5%">
					<col width="5%">
					<col width="5%">
					<col width="5%">
					<col width="10%">
					<col width="5%">
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
					
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>age</th>
						<th>email</th>
						<th>bloodgroup</th>
						<th>weight</th>
						<th>height</th>
						<th>address</th>
						<th>gender</th>
						<th>Date_joined</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i = 1;
					$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
					$where = "";
					
					$qry = $conn->query("SELECT * FROM patient ");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						
		             
						
		               
						
						
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
							<p><b><?php echo ucwords($row['Firstname']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Lastname']) ?></b></p>
							
						</td>

						<td>
							<p><b><?php echo ucwords($row['age']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['email']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['bloodgroup']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['weight']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['height']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['address']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['gender']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Date_joined']) ?></b></p>
							
						</td>
						
						
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php echo $row['Patient_Id'] ?>" data-id="<?php echo $row['Patient_Id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      
		                      <a class="dropdown-item" href="./index.php?page=edit_project&id=<?php echo $row['Patient_Id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['Patient_Id'] ?>">Delete</a>
		                  
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	
	$('.delete_project').click(function(){
	_conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>