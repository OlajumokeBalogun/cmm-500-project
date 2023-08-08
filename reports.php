<?php include 'db_connect.php' ?>
 <div class="col-md-12">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Reports</b>
            <div class="card-tools">
            	<button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive" id="printable">
			<table class="table tabe-hover table-secondary table-striped table-bordered" id="list">
               <!--  <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup> -->
                <thead>
					<tr>
						
						<th>Prescription_id </th>
						<th>Patient_name</th>
						<th>Staff_name</th>
						<th>Drug_name</th>
						<th>Doctor_note</th>
						<th>Prescription Status</th>
						<th>Prescription_date</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					
					
					$qry = $conn->query("SELECT * FROM Prescription ");
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
						<td>
							<p><b><?php echo ucwords($row['prescription_status']) ?></b></p>
						
						</td>
						<td>
							<p><b><?php echo ucwords($row['Prescription_date']) ?></b></p>
						
						</td>
						
					</tr>	
				<?php endwhile; ?>
				</tbody>
              </table>
            </div>
          </div>
        </div>
        </div>
<script>
	$('#print').click(function(){
		start_load()
		var _h = $('head').clone()
		var _p = $('#printable').clone()
		var _d = "<p class='text-center'><b>Reports and Analytics as of (<?php echo date("F d, Y") ?>)</b></p>"
		_p.prepend(_d)
		_p.prepend(_h)
		var nw = window.open("","","width=900,height=600")
		nw.document.write(_p.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)
	})
</script>