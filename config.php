<?php

require_once 'vendor/autoload.php';



// init configuration
$clientID = '223063612187-73ekpjk4trrd24lm6v0cgtvrqpvcs4e7.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/cmm-500-project/';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");


// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "kikedb";

$conn = mysqli_connect($hostname, $username , $password, $database);