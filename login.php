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
    <link rel="stylesheet" href="../assets/Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/Font-Awesome-master/js/all.min.js"></script>
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
            <img src="assets\img\female-medical-workers-created-with-generative-ai-technology.jpg" class="d-block w-100" alt="Image 1">
          </div>
          
          <div class="carousel-item">
            <img src="assets\img\blurred-abstract-background-interior-view-looking-out-toward-empty-office-lobby-entrance-doors-glass-curtain-wall-with-frame.jpg" class="d-block w-100" alt="Image 3">
          </div>
          <div class="carousel-item">
            <img src="assets\img\close-up-medical-team-ready-work (1).jpg" class="d-block w-100" alt="Image 4">
          </div>
          <div class="carousel-item">
            <img src="assets\img\empty-hallway-background (1).jpg" class="d-block w-100" alt="Image 5">
          </div>
          <div class="carousel-item">
            <img src="assets\img\empty-hallway-background.jpg" class="d-block w-100" alt="Image 6">
          </div>
          <div class="carousel-item">
            <img src="assets\img\empty-stomatology-orthodontist-hospital-cabinet-with-nobody-it.jpg" class="d-block w-100" alt="Image 7">
          </div>
          
          <div class="carousel-item">
            <img src="assets\img\team-young-specialist-doctors-standing-corridor-hospital (1).jpg" class="d-block w-100" alt="Image 10">
          </div>
          
        </div>
      </div>
    
    <!-- Login Container -->
    <div class="login-container">
    <style>
        /* CSS for the div container */
        .welcome-container {
            font-size: 15px; /* You can adjust the font size as per your preference */
            text-align: center; /* Center the text horizontally */
            padding: 20px; /* Add some padding around the text */
            border: 1px solid #ccc; /* Add a border for better visibility */
            max-width: 400px; /* Set a maximum width for the container */
            margin: 0 auto; /* Center the container on the page */
        }
    </style>
      <style>
        /* Custom CSS for the hover effect */
        .btn-primary.bg-gradient.rounded:hover {
            transform: scale(1.05); /* Increase the size slightly on hover */
        }
    </style>
    <style>
        /* Custom CSS class to reduce font size */
        .btn-smaller-font {
            font-size: 5px; /* Adjust the font size as needed */
        }
    </style>
      <style>
        /* Custom CSS for widening the space between buttons */
        .custom-margin {
            margin-right: 10px; /* Adjust the margin value to increase or decrease the space */
        }
    </style>

     <div class="welcome-container">
        <h4>Welcome back!!!</h4>
        <div class="row">
            
            <div class="col-md-1">

            </div>
            <section class="col-md-12" >
               
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
                               <input type="email" name="email" id="email" class="form-control rounded"  value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" autofocus required>
                            </div>
                           <div class="form-group">
                               <label for="password" class="label-control">Password</label>
                               <input type="password" name="password" id="password" class="form-control rounded" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>" required>
                            </div>
                            <div class="clear-fix mb-4"></div>
                            <div class="form-group text-end">

                            <button class="btn btn-primary bg-gradient rounded custom-margin">Login with OTP</button>
                            <button class="btn btn-primary bg-gradient rounded custom-margin">Login with Google</button>
                            </div>
                            
                       </form>
                       
            </section>

        </div>
    </div>
  </div>
  
  <script>
    // Add JavaScript to activate carousel every 3 seconds
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 2000 // Slide every 3 seconds
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>