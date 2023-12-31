<?php include'db_connect.php' ?>
<div class="col-md-12">
	<div class="card card-outline card-success">
		<div class="card-header">
            
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./baola.php?page=new_prescription"><i class="fa fa-plus"></i> Add New Prescription</a>
			</div>
            
		</div>
		<div class="card-body">
		<table class="table tabe-hover table-secondary table-striped table-bordered" id="list">
				
				<thead>
					<tr>
						
						<th>Prescription_id </th>
						<th>Patient_name</th>
						<th>Staff_name</th>
						<th>Drug_name</th>
						<th>Doctor_note</th>
						<th>Prescription Status</th>
						<th>Prescription_date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					
					$qry = $conn->query("SELECT * FROM prescription ");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						
					?>
					<tr>
						
						<td>
							<p><b><?php echo ucwords($row['Prescription_id']) ?></b></p>
						
						</td>
						
						<td>
							<p><b><?php echo ucwords($row['Patient_name']) ?></b></p>
						
						</td>

						<td>
							<p><b><?php echo ucwords($row['Staff_name']) ?></b></p>
						
						</td>

						<td>
							<p><b><?php echo ucwords($row['Drug_name']) ?></b></p>
						
						</td>

						<td>
							<p><b><?php echo ucwords($row['Doctor_note']) ?></b></p>
						
						</td>
						<td class="text-center">
							<?php
							  if(($row['prescription_status'])  =='Collected'){
								echo "<span class='badge badge-info'>{$row['prescription_status']}</span>";
							  }elseif(($row['prescription_status']) =='Awaiting Collection'){
							  	echo "<span class='badge badge-secondary'>{$row['prescription_status']}</span>";
							  }
							?>
						</td>
						
						<td>
							<p><b><?php echo ucwords($row['Prescription_date']) ?></b></p>
						
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./baola.php?page=view_prescription&Prescription_id=<?php echo $row['Prescription_id'] ?>" data-id="<?php echo $row['Prescription_id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                    
		                      <a class="dropdown-item" href="./baola.php?page=edit_prescription&Prescription_id=<?php echo $row['Prescription_id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_prescription" href="delete.php?action=delete_prescription&id=<?php echo $row['Prescription_id'] ?>">Delete</a>
		                

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
	
	$('.delete_prescription').click(function(){
	_conf("Are you sure to delete this prescription","delete_prescription",[$(this).attr('Prescription_id')])
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_prescription',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("prescription successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE