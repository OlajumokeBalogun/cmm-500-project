<?php
include('session_manager.php');
require_once 'config.php';

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  // save user data into session
  $_SESSION['user_token'] = $token;
} 

$link = $_SERVER['PHP_SELF'];
if(!strpos($link,'login.php') && !strpos($link,'login_verification.php') && !strpos($link,'registration.php') && !isset($_SESSION['user_login']) && !isset($_SESSION['user_token'])){
echo "<script>location.replace('./login.php');</script>";
}
if(strpos($link,'login_verification.php') && !isset($_SESSION['otp_verify_user_id'])){
    echo "<script>location.replace('./login.php');</script>";
}
if(strpos($link,'login.php') > -1 && isset($_SESSION['user_login'])){
echo "<script>location.replace('./');</script>";
}
?>
