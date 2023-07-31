<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
            
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_drugs"><i class="fa fa-plus"></i> Add New drugs</a>
			</div>
            
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="10%">
					<col width="30%">
					<col width="30%">
					<col width="30%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Drug_Id</th>
						<th>Drug_name</th>
						<th>Drug_desc</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					$qry = $conn->query("SELECT * FROM drug ");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
					
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
							<p><b><?php echo ucwords($row['Drug_id']) ?></b></p>
							
						</td>
						<td>
						<p><b><?php echo ucwords($row['Drug_name ']) ?></b></p>
							</td>
							<td>
							<p><b><?php echo ucwords($row['Drug_desc']) ?></b></p>
							
						</td>	
							
							
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_drug&id=<?php echo $row['Drug_id'] ?>" data-id="<?php echo $row['Drug_id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                     
		                      <a class="dropdown-item" href="./index.php?page=edit_drug&id=<?php echo $row['Drug_id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_drug" href="javascript:void(0)" data-id="<?php echo $row['Drug_id'] ?>">Delete</a>
		                 
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
	_conf("Are you sure to delete this drug?","delete_drug",[$(this).attr('Drug_id')])
	})
	})
	function delete_drug($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_drug',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Drug successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>