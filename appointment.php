<?php include'db_connect.php' ?>

<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
            
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./baola.php?page=new_appointment"><i class="fa fa-plus"></i> Add New Appointment</a>
			</div>
            
		</div>
		<div class="card-body">
		<table class="table tabe-hover table-secondary table-striped table-bordered" id="list">
				<colgroup>
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Patient Name</th>
						<th>Doctor Name</th>
						<th>Staff schedulings</th>
						<th>Appointment_date</th>
						<th>Appointment_time</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
					$where = "";
					
					$qry = $conn->query("SELECT * FROM appointment ");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td>
							<p><b><?php echo ucwords($row['Patient_name']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['doctor_name']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['staff_scheduling']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['Appointment_date']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['Appointment_time']) ?></b></p>
						</td>
						<td class="text-center">
							<?php
							  if(($row['status'])  =='Pending'){
								echo "<span class='badge badge-info'>{$row['status']}</span>";
							  }elseif(($row['status']) =='On-Hold'){
							  	echo "<span class='badge badge-warning'>{$row['status']}</span>";
							  }elseif(($row['status']) =='Done'){
								echo "<span class='badge badge-secondary'>{$row['status']}</span>";
							}
							?>
						</td>
						
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project"href="./baola.php?page=view_appointment&Appointment_id=<?php echo $row['Appointment_id'] ?>" data-id="<?php echo $row['Appointment_id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                     
		                      <a class="dropdown-item" href="./baola.php?page=edit_appointment&Appointment_id=<?php echo $row['Appointment_id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_appointment" href="delete.php?action=delete_appointment&id=<?php echo $row['Appointment_id'] ?>">Delete</a>
		                 
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
	
	$('.delete_appointment').click(function(){
	_conf("Are you sure to delete this appointment?","delete_appointment",[$(this).attr('data-id')])
	})
	})
	function delete_appointment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_appointment',
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

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE