<?php

require_once 'vendor/autoload.php';



// init configuration
$clientID = '534038609743-j2ribnp87nv3pm8cai8a681o5idri4cs.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://kike.online/welcome.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");




?>