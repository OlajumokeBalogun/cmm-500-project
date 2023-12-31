  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000080;">
    <style>
    .bg-navy {
    background-color: navy; /* Choosing the  desired color */
}
 </style>
      
    
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./baola.php" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>  
          <?php if ($_SESSION['type'] == 'admin') : ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
           
              <li class="nav-item">
                <a href="./baola.php?page=new_user" class="nav-link nav-new_project tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>

             
            
              <li class="nav-item">
                <a href="./baola.php?page=user_list" class="nav-link nav-project_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li> 
          
          <?php endif; ?>
          <li class="nav-item">
                <a href="./baola.php?page=patient" class="nav-link nav-task_list">
                <i class="nav-icon fas fa-hospital-user"></i>
               
                  <p>Patient</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="./baola.php?page=appointment" class="nav-link nav-task_list">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Appointment</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="./baola.php?page=calender" class="nav-link nav-task_list">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Calender</p>
                </a>
          </li>
          <?php if ($_SESSION['type'] != 'receptioni') : ?>
          <li class="nav-item">
                <a href="./baola.php?page=drugs" class="nav-link nav-task_list">
                  <i class="nav-icon fas fa-capsules"></i>
                  <p>Drugs</p>
                </a>
          </li>
          <?php endif; ?>
          <?php if ($_SESSION['type'] != 'receptioni') : ?>
          <li class="nav-item">
                <a href="./baola.php?page=billing" class="nav-link nav-task_list">
                <i class="nav-icon fas fa-pound-sign"></i>
                  <p>Billing</p>
                </a>
          </li>
         
          <?php endif; ?>
          <?php if ($_SESSION['type'] != 'receptioni') : ?>
          <li class="nav-item">
                <a href="./baola.php?page=test" class="nav-link nav-task_list">
                  <i class="nav-icon fas fa-vial"></i>
                  <p>Tests</p>
                </a>
          </li>
          <?php endif; ?>
          <?php if ($_SESSION['type'] != 'receptioni') : ?>
          <li class="nav-item">
                <a href="./baola.php?page=prescription" class="nav-link nav-task_list">
                <i class="nav-icon fas fa-prescription"></i>
                  <p>Prescription</p>
                </a>
          </li>
          <?php endif; ?>
          <?php if ($_SESSION['type'] != 'receptioni') : ?>
           <li class="nav-item">
                <a href="./baola.php?page=reports" class="nav-link nav-reports">
                <i class="nav-icon fas fa-chart-line"></i>
                  <p>Report</p>
                </a>
          </li>

          <?php endif; ?>
          <?php if($_SESSION['firstname'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./baola.php.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./baola.php.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>
  //Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE