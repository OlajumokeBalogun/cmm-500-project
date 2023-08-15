<?php
require_once('auth.php');
require_once('MainClass.php');

require_once 'config.php';
include('db_connect.php');
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo = [
    'email' => $google_account_info['email'],
    'first_name' => $google_account_info['givenName'],
    'last_name' => $google_account_info['familyName'],
    'gender' => $google_account_info['gender'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
  ];

  // checking if user is already exists in database
  $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
       
       $_SESSION['user_login'] = $result;
        header("Location: https://kike.online/baola.php"); // Change to your dashboard page
        exit();
  } else {
   
      header("Location: https://kike.online/index.php"); // Change to your dashboard page
        exit();
    
    }
  

  // save user data into session
  $_SESSION['user_login'] = $result;


  
}

?>