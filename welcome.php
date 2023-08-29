<?php
require_once('auth.php');
require_once('MainClass.php');

require_once 'config.php';
include('db_connect.php');
// the authenticate code from Google OAuth Flow....lets see if this magic works...
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // getting profile info from google..here is my wishlist of all i want to see about you!
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

  // checking if user is already exists in my database
  $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
       
       $_SESSION['user_login'] = $result;
        header("Location: https://kike.online/baola.php"); // straight access to the dashboard page..you are welcome
        exit();
  } else {
   
      header("Location: https://kike.online/index.php"); // keep sending user back to index page..lets leave them wondering..hahaha!!!
        exit();
    
    }
  

  // save user data into session
  $_SESSION['user_login'] = $result;


  
}

?>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE