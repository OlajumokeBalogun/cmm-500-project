<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
            
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_test"><i class="fa fa-plus"></i> Add New Test</a>
			</div>
            
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				
				<thead>
					<tr>
						
						<th>Test_Id</th>
						<th>Patient Name</th>
						<th>Staff Name</th>
						<th>Test_name</th>
						<th>Test_results</th>
						<th>Test_date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					
					$qry = $conn->query("SELECT * FROM test  ");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						

		                
					?>
					<tr>
						
						<td>
							<p><b><?php echo ucwords($row['Test_id']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Patient_name']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Staff_name']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Test_name']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Test_results']) ?></b></p>
							
						</td>
						<td>
							<p><b><?php echo ucwords($row['Test_date']) ?></b></p>
							
						</td>
						
						
							
					
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_test&Test_id=<?php echo $row['Test_id'] ?>" data-id="<?php echo $row['Test_id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      
		                      <a class="dropdown-item" href="./index.php?page=edit_test&id=<?php echo $row['Test_id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['Test_id'] ?>">Delete</a>
		                 
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
	function delete_test($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_test',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Test successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>