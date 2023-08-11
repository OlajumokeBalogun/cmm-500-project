<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Function to sanitize input and prevent SQL injection
    function sanitize_input($input) {
        return htmlspecialchars(trim($input));
    }

    // Function to validate the password strength
    function is_valid_password($password) {
        
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password);
    }

    // Retrieve the form data
    $firstname = sanitize_input($_POST['firstname']);
    $middlename = sanitize_input($_POST['middlename']);
    $lastname = sanitize_input($_POST['lastname']);
    $type = sanitize_input($_POST['type']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password']; // No need to sanitize the password as it will be hashed.
    $cpass = $_POST['cpass']; // No need to sanitize the password as it will be hashed.
    $id = ($_POST['id']);

    // Validate the password strength
    if (!is_valid_password($password)) {
        echo "<script>
                alert('password strength  not ok');
                setTimeout(function() {
                    window.location.href = 'index.php?page=new_user';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
            
         exit;
    }

    // Check if the password and confirm password match
    if ($password !== $cpass) {
        echo "Passwords do not match. Please enter the same password twice.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    
    include ('db_connect.php');

    if (empty($id)) {
        // INSERT query
        $stmt = $conn->prepare("INSERT INTO users (firstname, middlename, lastname, type, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstname, $middlename, $lastname, $type, $email, $hashedPassword);
    } else {
        // UPDATE query
        $stmt = $conn->prepare("UPDATE users SET firstname=?, middlename=?, lastname=?, type=?, email=?, password=? WHERE id=?");
        $stmt->bind_param("ssssssi", $firstname, $middlename, $lastname, $type, $email, $hashedPassword, $id);
    }


   

    if ($stmt->execute()) {
        echo "<script>
                alert('user records updated.');
                setTimeout(function() {
                    window.location.href = 'index.php?page=user_list';
                }, 50); // 1000 milliseconds = 3 seconds
            </script>";
        send_mail($email, $firstname, $password); 
    } else {
        echo "Error: " . $stmt->error;
    }

  
    $stmt->close();
    $conn->close();
}

function send_mail($to = "", $firstname = "", $password = "")
{
    if (!empty($to)) {
        try {
            $email = 'testbaola20@gmail.com';
            $headers = 'From: ' . $email . '\r\n' . 'Reply-To: ' .
                $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion() . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // The message
            $msg = "
            <html>
                <body>
                    <h2>Baola Hospital System Application: Your New Default Password and Important Account Update</h2>
                    <p>Dear $firstname,</p>

                    <p>We hope this message finds you well. We are writing to inform you that your account password has been reset, and we have generated a new default password for you.</p>

                    <p>Your new default password is: $password</p>

                    <p>For security purposes, we strongly recommend that you change your password immediately upon logging in to your account. Please follow these steps to change your password:</p>

                    <ol>
                        <li>Log in to your account using your current username and the above default password.</li>
                        <li>Once logged in, navigate to the <a href='http://localhost/cmm-500-project/update_password.php'>Update_password</a> or 'Account Settings' section.</li>
						
                    </ol>

                    <p>Please remember to create a strong password that includes a combination of uppercase and lowercase letters, numbers, and special characters. Your password should be at least 8 characters long.</p>

                    <p>If you have any difficulties changing your password or need further assistance, please don't hesitate to contact our support team at [Your Support Email or Phone Number].</p>

                    <p>Thank you for being a valued member of our community. We prioritize the security of our users, and updating your password is an essential step in maintaining the confidentiality of your account.</p>

                    <p>Best regards,</p>
                    <p>[Baola EHR Support Team]</p>
                </body>
            </html>
            ";

            // Send email
            mail($to, 'Your New Default Password and Important Account Update', $msg, $headers);

        } catch (Exception $e) {
            // Handle exception if needed
        }
    }
}
?>
