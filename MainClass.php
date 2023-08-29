<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require 'PHPMailer/src/Exception.php';

/* The main PHPMailer class. */
require 'PHPMailer/src/PHPMailer.php';

/* SMTP class, needed if you want to use SMTP. */
require 'PHPMailer/src/SMTP.php';

require 'vendor/autoload.php';

Class MainClass{
    protected $db;
    function __construct(){
        $this->db = new mysqli('localhost','u614785957_Kikelomo','Kikelomo123@','u614785957_kikedb');
        if(!$this->db){
            die("Database Connection Failed. Error: ".$this->db->error);
        }
    }
    function db_connect(){
        return $this->db;
    }
    
    public function login(){
        extract($_POST);
        $sql = "SELECT * FROM users where email = ? ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $data = $result->fetch_array();
            $pass_is_right = password_verify($password,$data['password']);
            $has_code = false;
    
            // I chose  3 as a constant for the maximum number of failed attempts
            define("MAX_ATTEMPTS", 3);
    
            // Initializing a session variable to store the number of failed attempts so system starts counting
            if (!isset($_SESSION['failed_attempts'])) {
                $_SESSION['failed_attempts'] = 0;
            }
    
            // we need to see of the OTP has expired or not
            if (is_null($data['otp']) || (!is_null($data['otp']) && !is_null($data['otp_expiration']) && strtotime($data['otp_expiration']) 
            < time())) {
                // Check if the password is correct
                if ($pass_is_right) {
                    // Reseting the number of failed attempts
                    $_SESSION['failed_attempts'] = 0;
    
                    $otp = sprintf("%'.06d",mt_rand(0,999999));
                    $expiration = date("Y-m-d H:i" ,strtotime(date('Y-m-d H:i')." +2 mins"));
                    $update_sql = "UPDATE users set otp_expiration = '{$expiration}', otp = '{$otp}' where id='{$data['id']}' ";
                    $update_otp = $this->db->query($update_sql);
                    if($update_otp){
                        $has_code = true;
                        $resp['status'] = 'success';
                        $_SESSION['otp_verify_user_id'] = $data['id'];
                        $this->send_mail($data['email'], $data['firstname'], $otp);
                    }else{
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' An error occurred while loggin in. Please try again later.';
                    }
                } else {
                    // failed attempts is starting to increase!!!
                    $_SESSION['failed_attempts']++;
    
                    // Checking if the number of failed attempts has reached the limit i set
                    if ($_SESSION['failed_attempts'] >= MAX_ATTEMPTS) {
                        // Lock the user out and display an error message,now i need to reset them
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' You have exceeded the maximum number of login attempts. Please try again later.';
                    } else {
                        // Display an error message for incorrect password
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' Incorrect Password';
                    }
                }
            } else {
                // The OTP is still valid
                $resp['status'] = 'success';
                $_SESSION['otp_verify_user_id'] = $data['id'];
            }
        } else {
            // Display an error message for unregistered email
            $resp['status'] = 'failed';
            $_SESSION['flashdata']['type'] = 'danger';
            $_SESSION['flashdata']['msg'] = ' Email is not registered.';
        }
        return json_encode($resp);
    }
    
    



    
    public function get_user_data($id){
        extract($_POST);
        $sql = "SELECT * FROM `users` where `id` = ? ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dat=[];
        if($result->num_rows > 0){
            $resp['status'] = 'success';
            foreach($result->fetch_array() as $k => $v){
                if(!is_numeric($k)){
                    $data[$k] = $v;
                }
            }
            $resp['data'] = $data;
        }else{
            $resp['status'] = 'false';
        }
        return json_encode($resp);
    }
    public function resend_otp($id){
        $otp = sprintf("%'.06d",mt_rand(0,999999));
        $expiration = date("Y-m-d H:i" ,strtotime(date('Y-m-d H:i')." +2 mins"));
        $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where id = '{$id}' ";
        $update_otp = $this->db->query($update_sql);
        if($update_otp){
            $resp['status'] = 'success';
            $email = $this->db->query("SELECT email FROM `users` where id = '{$id}'")->fetch_array()[0];
            $this->send_mail($email, $firstname, $otp);
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->db->error;
        }
        return json_encode($resp);
    }
    public function otp_verify(){
        extract($_POST);
         $sql = "SELECT * FROM `users` where id = ? and otp = ?";
         $stmt = $this->db->prepare($sql);
         $stmt->bind_param('is',$id,$otp);
         $stmt->execute();
         $result = $stmt->get_result();
         if($result->num_rows > 0){
             $resp['status'] = 'success';
             $this->db->query("UPDATE `users` set otp = NULL, otp_expiration = NULL where id = '{$id}'");
             $_SESSION['user_login'] = 1;
             foreach($result->fetch_array() as $k => $v){
                 if(!is_numeric($k))
                 $_SESSION[$k] = $v;
             }
         }else{
             $resp['status'] = 'failed';
             $_SESSION['flashdata']['type'] = 'danger';
             $_SESSION['flashdata']['msg'] = ' Incorrect OTP.';
         }
         return json_encode($resp);
    }
    
    
    function send_mail($to="",$firstname="", $pin=""){
        $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testbaola20@gmail.com';
        $mail->Password = 'dwytcvdlzkbdobfp';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('testbaola20@gmail.com', 'Baola Hospital');
        $mail->addAddress($to, $firstname, $pin); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Secure Login - Action Required';
        $mail->Body    = "Dear $firstname, <br><br> Here is your 6 digits OTP (One-Time PIN) $pin to verify your Identity. <br>Please use it within the next two minutes to access your account. <br><br> If you didn't initiate this login, contact us immediately at testbaola20@gmail.com] .
 <br><br>
Never share your OTP. We won't ask for it via email or phone.
 <br><br>
Best regards,
<br><br>
[Baola EHR Support team]";

        $mail->send();
        
    }catch(Exception $e){
        $_SESSION['flashdata']['type']='danger';
        $_SESSION['flashdata']['msg'] = ' An error occurred while sending the OTP. Error: '.$e->getMessage();
    }
}
}


$class = new MainClass();
$conn= $class->db_connect();

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE