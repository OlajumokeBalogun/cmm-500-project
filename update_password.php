<?php

include('db_connect.php');
require 'vendor/autoload.php'; // Assuming you installed GuzzleHttp using composer.
use GuzzleHttp\Client;

$client = new GuzzleHttp\Client([
    'base_uri' => 'https://api.abuseipdb.com/api/v2/'
]);

// Get the user's remote IP address
$userIp = $_SERVER['REMOTE_ADDR'];

try {
    $response = $client->request('GET', 'check', [
        'query' => [
            'ipAddress' => $userIp,
            'maxAgeInDays' => '90',
        ],
        'headers' => [
            'Accept' => 'application/json',
            'Key' => '71ee5cc81e4b166346891de959010cabcf9176343d8b6ee9510d374e3e007c1a41f93730bae4d207'
        ],
    ]);

    $output = $response->getBody();
    $ipDetails = json_decode($output, true);

    if (
        isset($ipDetails['data']['countryCode']) &&
        $ipDetails['data']['countryCode'] === 'GB' &&
        $ipDetails['data']['abuseConfidenceScore'] <= 25
    ) {
        // Display a message if conditions are met
        // Insert redirection code here if needed
    } else {
    header("Location: error.php"); // Redirect to error.php if conditions are not met
    exit; // Stop further processing
}
} catch (\Exception $e) {
    // Handle exception (e.g., log the error, show a generic error message to the user)
    echo "Error: " . $e->getMessage();
}

// Function to sanitize input
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}




$message = ""; 
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $old_password = sanitizeInput($_POST["old_password"]);
    $new_password = sanitizeInput($_POST["new_password"]);

    // Validate password strength
    $password_valid = strlen($new_password) >= 8 && preg_match("#[0-9]+#", $new_password) && preg_match("#[a-z]+#", $new_password) && preg_match("#[A-Z]+#", $new_password) && preg_match("/[!@#%^&*]+/", $new_password);


    if (!$password_valid) {
        $message = "Password must be at least 8 characters long and contain at least one number, one uppercase letter, one lowercase letter, and one special character.";
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Check if the user exists in the database and validate the password
        // Replace 'your_users_table' with the actual name of your users table
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User is authenticated
            $row = $result->fetch_assoc();

            if ($row["password"] === null) {
                // User is a first-timer
                $message = "User is a first-timer.";
            } else {
                // Validate the old password
                if (password_verify($old_password, $row["password"])) {
                    
                    $sql = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
                    if ($conn->query($sql) === true) {
                        $success = "Password updated successfully.";
                        echo "<script>
                setTimeout(function() {
                    window.location.href = 'https://www.kike.online/login.php';
                }, 1000); 
            </script>";
                        
                    } else {
                        $message = "Error updating password: " . $conn->error;
                    }
                } else {
                    $message = "Invalid old password";
                }
            }
        } else {
            $message = "Invalid email";
        }
    }
}

// Close the database connection
$conn->close();
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
          <img src="assets\img\access-connection-internet-technology-concept.jpg" class="d-block w-100" alt="Image 3">
          </div>
       
          <div class="carousel-item">
            <img src="assets\img\woman-working-computer-network-graphic-overlay.jpg" class="d-block w-100" alt="Image 4">
          </div>
          <div class="carousel-item">
            <img src="assets\img\password-access-lock-padlock-privacy-safety-concept.jpg" class="d-block w-100" alt="Image 5">
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

    <title>Update Password</title>
</head>
<body>
    <div class="welcome-container">
    <h4>Update Password</h4>
    <div class="row">
        <section class="col-md-12">
            <?php
            if (!empty($message)) {
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
            ?> <?php
            if (!empty($success)) {
                echo '<div class="alert alert-success" role="alert">' . $success . '</div>';
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group row">
                <label for="email" class="form-label">Email:</label>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            
                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password:</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </section>
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

               