<?php
require_once('auth.php');
require_once('MainClass.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $login = json_decode($class->login());
    if($login->status == 'success'){
        echo "<script>location.replace('./login_verification.php');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with OTP</title>
    <link rel="stylesheet" href="./Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./Font-Awesome-master/js/all.min.js"></script>
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
</head>
<body class="bg-dark bg-gradient">
<div class="carousel-container">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets\img\pexels-tom-fisk-1692693.jpg" class="d-block w-100" alt="Image 1">
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
               
            <form action="./login.php" method="POST">
                       <?php 
                            if(isset($_SESSION['flashdata'])):
                        ?>
                        <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?> my-2 rounded-0">
                            <div class="d-flex align-items-center">
                                <div class="col-11"><?php echo $_SESSION['flashdata']['msg'] ?></div>
                                <div class="col-1 text-end">
                                    <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php unset($_SESSION['flashdata']) ?>
                        <?php endif; ?>
                           <div class="form-group">
                               <label for="email" class="label-control">Email</label>
                               <input type="email" name="email" id="email" class="form-control rounded-0" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" autofocus required>
                            </div>
                           <div class="form-group">
                               <label for="password" class="label-control">Password</label>
                               <input type="password" name="password" id="password" class="form-control rounded-0" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>" required>
                            </div>
                            <div class="clear-fix mb-4"></div>
                            <div class="form-group text-end">
                                <button class="btn btn-primary bg-gradient rounded-0">LOGIN</button>
                            </div>
                            
                       </form>
            </section>

        </div>
    </div>
  </div>
</body>
</html>