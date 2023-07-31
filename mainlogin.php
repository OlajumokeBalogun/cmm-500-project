<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
  ob_start();
  // if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  // }
  ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
<?php include 'header.php' ?>
<style>
    /* Reset some default styles for better consistency */
    body, html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    /* Styling for the carousel container */
    .carousel-container {
      position: relative;
      height: 100vh; /* Set the height to fill the viewport */
      overflow: hidden; /* Hide overflowing carousel images */
    }

    .carousel-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0.3; /* Adjust the opacity of the carousel images for better visibility of the login form */
      z-index: -1; /* Push the images to the background */
    }

    /* Styling for the login container */
    .login-container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent background for better readability */
      padding: 20px;
      border-radius: 8px;
      z-index: 1; /* Ensure the login form is above the carousel images */
    }

    /* Other styles for the login form, buttons, etc. can be added here */
  </style>
<body class="hold-transition login-page bg-black">
<!-- Carousel Container -->
<div class="carousel-container">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets/img/asian-patient-holding-clipboard-filling-medical-report-while-discussing-health-care-treatment-with-specialist-medic-during-consultation-hospital-waiting-area-diverse-people-standing-reception.jpg" class="d-block w-100" alt="Image 1">
          </div>
          <div class="carousel-item">
            <img src="assets/img/healthcare-specialist-explaining-senior-woman-diagnosis-braing-trauma-tablet-pc.jpg" class="d-block w-100" alt="Image 2">
          </div>
          <div class="carousel-item">
            <img src="assets/img/clinical-reception-with-waiting-room-facility-lobby-registration-counter-used-patients-with-medical-appointments-empty-reception-desk-health-center-checkup-visits.jpg" class="d-block w-100" alt="Image 3">
          </div>
        </div>
      </div>
    
    <!-- Login Container -->
    <div class="login-container">
        <h3>Welcome Back!!!</h3>
        <div class="row">
            <section class="col-md-4">

                <img src="assets/img/doctor-workplace-top-view-doctor-office-work-with-stethoscope-laptop-pen-clipboard-with-copy-space-your-text-modern-medical-information-technology-flat-lay-copy-space.jpg" alt="PalTours Logo" width="200" height="200"">
    
            </section>
            <div class="col-md-1">

            </div>
            <section class="col-md-7" >
               
                <form action="" id="login-form">
                    <div>
                        <input type="email" name="email" id="" placeholder="STAFF ID">
                    </div>
                    <br>
                    <div>
                        <input type="password" name="password" id="" placeholder="Password">
                    </div>
                   <br>
    
                    <button type="submit">Login with FaceID</button>
                    <br><br>
                    <button type="submit">Login with FingerPrint</button>
                </form>
            </section>

        </div>
    </div>
  </div>
<!-- /.login-box -->
<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
    e.preventDefault()
    start_load()
    if($(this).find('.alert-danger').length > 0 )
      $(this).find('.alert-danger').remove();
    $.ajax({
      url:'ajax.php?action=login',
      method:'POST',
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        end_load();

      },
      success:function(resp){
        if(resp == 1){
          location.href ='index.php?page=home';
        }else{
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          end_load();
        }
      }
    })
  })
  })
</script>
<?php include 'footer.php' ?>

</body>
</html>
