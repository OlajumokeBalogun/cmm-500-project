<?php




Class MainClass{
    protected $db;
    function __construct(){
        $this->db = new mysqli('localhost','root','','kikedb');
        if(!$this->db){
            die("Database Connection Failed. Error: ".$this->db->error);
        }
    }
    function db_connect(){
        return $this->db;
    }
    
    public function login(){
        extract($_POST);
        $sql = "SELECT * FROM `users` where `email` = ? ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $data = $result->fetch_array();
            $pass_is_right = password_verify($password,$data['password']);
            $has_code = false;
    
            // Define a constant for the maximum number of failed attempts
            define("MAX_ATTEMPTS", 3);
    
            // Initialize a session variable to store the number of failed attempts
            if (!isset($_SESSION['failed_attempts'])) {
                $_SESSION['failed_attempts'] = 0;
            }
    
            // Check if the OTP is expired or not set
            if (is_null($data['otp']) || (!is_null($data['otp']) && !is_null($data['otp_expiration']) && strtotime($data['otp_expiration']) < time())) {
                // Check if the password is correct
                if ($pass_is_right) {
                    // Reset the number of failed attempts
                    $_SESSION['failed_attempts'] = 0;
    
                    $otp = sprintf("%'.06d",mt_rand(0,999999));
                    $expiration = date("Y-m-d H:i" ,strtotime(date('Y-m-d H:i')." +2 mins"));
                    $update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where id='{$data['id']}' ";
                    $update_otp = $this->db->query($update_sql);
                    if($update_otp){
                        $has_code = true;
                        $resp['status'] = 'success';
                        $_SESSION['otp_verify_user_id'] = $data['id'];
                        $this->send_mail($data['email'],$otp);
                    }else{
                        $resp['status'] = 'failed';
                        $_SESSION['flashdata']['type'] = 'danger';
                        $_SESSION['flashdata']['msg'] = ' An error occurred while loggin in. Please try again later.';
                    }
                } else {
                    // Increment the number of failed attempts
                    $_SESSION['failed_attempts']++;
    
                    // Check if the number of failed attempts has reached the limit
                    if ($_SESSION['failed_attempts'] >= MAX_ATTEMPTS) {
                        // Lock the user out and display an error message
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
            $this->send_mail($email,$otp);
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
    
    
    function send_mail($to="",$pin=""){
        if(!empty($to)){
            try{
                $email = 'testbaola20@gmail.com';
                $headers = 'From:' .$email . '\r\n'. 'Reply-To:' .
                $email. "\r\n" .
                'X-Mailer: PHP/' . phpversion()."\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // the message
                $msg = "
                <html>
                    <body>
                        <h2>You are Attempting to Login in Baola Hosipital System Application</h2>
                        <p>Here is your 6 digits OTP (One-Time PIN) to verify your Identity.</p>
                        <p>Your Pin will expire in 2 minutes</p>
                        
                        <h3><b>".$pin."</b></h3>
                    </body>
                </html>
                ";

                // send email
                mail($to,"OTP",$msg,$headers);
                // die("ERROR<br>".$headers."<br>".$msg);

            }catch(Exception $e){
                $_SESSION['flashdata']['type']='danger';
                $_SESSION['flashdata']['msg'] = ' An error occurred while sending the OTP. Error: '.$e->getMessage();
            }
        }
    }
    function __destruct(){
         $this->db->close();
    }
}
$class = new MainClass();
$conn= $class->db_connect();