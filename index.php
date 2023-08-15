<?php

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAOLA EHR</title>
    <link rel="stylesheet" href="./Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./Font-Awesome-master/js/all.min.js"></script>
    <style>
       .logo {
            position: absolute;
            top: 20px;
            left: 1px;
        }
    </style>
</head>
<body>
     <style>
        .navbar-brand {
            font-size: 18px; /* Adjust the font size as needed */
        }
    </style>
     <style>
    .bg-navy {
    background-color: navy; /* Define the desired color */
}
 </style>

<nav class="navbar navbar-expand-lg navbar-dark bg-navy blue">
    <div class="container-fluid">
        <a class="navbar-brand me-3" href="index.php"><img src="assets/img/PalTours.png" alt="PalTours Logo" width="50"></a> 
        <a class="navbar-brand me-3" href="index.php">Baola EHR</a> 
        <!-- Added "me-3" class for right margin -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto justify-content-between"> <!-- Added "justify-content-between" class -->
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item" style=""> <!-- Add margin to the left -->
                    <a class="nav-link" href="#Resource">Resource Center</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#covid">Covid-19 Protocols</a>
                </li>
                <li class="nav-item" style="">
                    <a class="nav-link" href="#staff">Staff of the Week</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#announcement">Announcements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#branches">Branches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#careers">Careers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#newsletter">Newsletter</a>
                </li>
                <!-- Add more navigation links as needed -->
            </ul>
        </div>
    </div>
</nav>
   <style>
.carousel-container {
    max-width: 100%; /* Adjust the width as needed */
    margin: 0 auto; /* Center the container */
    padding: 1px; /* Add padding for spacing */
}

.carousel-inner {
    max-height: 680px; /* Adjust the height as needed */
    overflow: hidden; /* Hide overflow content */
}
    </style>

<div class="col-sm-12">
    <div class="carousel-container">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets\img\female-medical-workers-created-with-generative-ai-technology.jpg" class="d-block w-100 img-fluid" alt="Image 7">
                </div>

                <div class="carousel-item">
                    <img src="assets\img\glass-designed-building-view.jpg" class="d-block w-100 img-fluid" alt="Image 3">
                </div>

                <div class="carousel-item">
                    <img src="assets\img\diverse-team-professional-surgeons-performing-invasive-surgery-patient-hospital-operating-room-nurse-hands-out-instruments-surgeon-anesthesiologist-monitors-vitals.jpg" class="d-block w-100 img-fluid" alt="Image 4">
                </div>

                <div class="carousel-item">
                    <img src="assets\img\front-view-smiley-doctors-work.jpg" class="d-block w-100 img-fluid" alt="Image 7">
                </div>

                <div class="carousel-item">
                    <img src="assets\img\cheerful-multiracial-doctors-hospital.jpg" class="d-block w-100 img-fluid" alt="Image 10">
                </div>

                <div class="carousel-item">
                    <img src="assets\img\happy-woman-talking-receptionist-while-arriving-spa.jpg" class="d-block w-100 img-fluid" alt="Image 10">
                </div>
            </div>
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

</body>
</html>
