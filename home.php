<?php include('db_connect.php') ?>

<!-- Info boxes -->
 <div class="col-12">
          <div class="card">
          <?php
// Get the current hour in 24-hour format
$currentHour = date('H');

// Define the greetings based on the time of day
if ($currentHour <= 5 && $currentHour < 12) {
    $greeting = 'Good morning';
} elseif ($currentHour <= 12 && $currentHour < 18) {
    $greeting = 'Good afternoon';
} else {
    $greeting = 'Good evening';
}

// Get the user's firstname from the session
$firstname = $_SESSION['firstname'];
?>

<div class="card-body">
  <?php echo $greeting; ?>, <?php echo $firstname; ?>!
</div>






          </div>
  </div>
  <hr>
  <?php 

    $where = "";
    
     
   
      $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['id']}]%' ";
    
    
   
  
     
   
    ?>
        
      <div class="row">
        <div class="col-md-8">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Appointment Progress</b>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Patient Name</th>
                  <th>Doctor Name</th>
                  <th>Status</th>
                  <th></th>
                </thead>
                <tbody>
                <?php
                $i = 1;

                $qry = $conn->query("SELECT * FROM appointment ");
                while($row= $qry->fetch_assoc()):
                  
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['Patient_name']) ?>
                          </a>
                          <br>
                          <small>
                              Due: <?php echo date("Y-m-d",strtotime($row['Appointment_date'])) ?>
                          </small>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['doctor_name']) ?>
                          </a>
                          
                          
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['status']) ?>
                          </a>
                          
                          
                      </td>
                      
                      <td>
                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_appointment&Appointment_id=<?php echo $row['Appointment_id'] ?>">
                              <i class="fas fa-folder">
                              </i>
                              View
                        </a>
                      </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM 	appointment ")->num_rows; ?></h3>

                <p>Total Appointment</p>
              </div>
              <div class="icon">
              <i class="nav-icon fas fa-calendar-check"></i>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM 	patient ")->num_rows; ?></h3>

                <p>Total Patient</p>
              </div>
              <div class="icon">
              <i class="nav-icon fas fa-hospital-user"></i>
              </div>
            </div>
          </div>
      </div>
        </div>
      </div>
