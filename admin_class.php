<?php
session_start();
//set php to display error on the web page when it occcurs
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() { //Creating a new class of the object 
		//starting output buffering
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() { //a class of the object is no longer needed 
	    $this->db->close();
	    ob_end_flush(); // turn off buffering
	}

	
	function logout() {
    

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit; // Ensure no further code is executed after the redirect
}

	
	function save_user()

{
    extract($_POST);
    
	$data = "";
	
    foreach ($_POST as $k => $v) {
        if (!in_array($k, array('id', 'cpass', 'password')) && !is_numeric($k)) {
            if (empty($data)) {
                $data .= " $k='$v' ";
            } else {
                $data .= ", $k='$v' ";
            }
        }
    }
	 if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $data .= ", password='$hashedPassword' ";
    }

    $check = $this->db->query("SELECT * FROM users where email ='$email'" . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
    if ($check > 0) {
        return 2;
        exit;
    }

    if (empty($id)) {
        $save = $this->db->query("INSERT INTO users set $data");
        $this->send_mail($email, $firstname, $password); // Pass the email and default password as arguments
    } else {
        $save = $this->db->query("UPDATE users set $data where id = $id");
    }

    if ($save) {
        return 1;
    }
}

function send_mail($to = "", $firstname = "", $password = "")
{
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
        $mail->addAddress($to, $firstname); // User's email and name

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Baola EHR';
        $mail->Body    = "
        <h2>Baola Hospital System Application: Your New Default Password and Important Account Update</h2>
        <p>Dear $firstname,</p>

        <p>I hope this message finds you well. I am writing to inform you that your account password has been set, and i have generated a default password for you.</p>

        <p>Your default password is: $password</p>

        <p>For security purposes,Please follow these steps to change your password:</p>

        <ol>
         
            <li>Click the <a href='https://kike.online/update_password.php'>Update_password</a> to change your password</li>
            
        </ol>
        <p>Please use the email adress you provided earlier while giving consent </p>
        <p>Please remember to create a strong password that includes a combination of uppercase and lowercase letters, numbers, and special characters. Your password should be at least 8 characters long.</p>

        <p>If you have any difficulties changing your password or need further assistance, please don't hesitate to contact the support team at [testbaola20@gmail.com].</p>

        <p>Thank you for being a valued member of this community. I prioritize the security of  users, and updating your password is an essential step in maintaining the confidentiality of your account.</p>

        <p>Best regards,</p>
        <p>[Baola EHR Support Team]</p>";

        $mail->send();

        } catch (Exception $e) {
            // Handle exception if needed
        }
    }
}






	

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(!empty($password))
			 $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        	$data .= ", password='$hashedPassword' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	
	
	
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE
