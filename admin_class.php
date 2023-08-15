<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	
	function logout() {
    // Unset all session variables
    session_unset();

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

function change_password($password_changed, $password_created) {
	// Check if password has been changed
	if ($password_changed) {
		return "Password has been changed.";
	} else {
		// Check if password has expired
		if (time() - $password_created > 60) {
			return "Password has expired.";
		} else {
			return "Password is still valid.";
		}
	}
}





	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password'){
					if(empty($v))
						continue;
					$v = md5($v);

				}
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
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $id;
				if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
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
	
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	
	function get_report(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where date(t.date_created) between '$date_from' and '$date_to' order by unix_timestamp(t.date_created) desc ");
		while($row= $get->fetch_assoc()){
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['name'] = ucwords($row['name']);
			$row['adult_price'] = number_format($row['adult_price'],2);
			$row['child_price'] = number_format($row['child_price'],2);
			$row['amount'] = number_format($row['amount'],2);
			$data[]=$row;
		}
		return json_encode($data);

	}
