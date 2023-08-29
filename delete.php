<?php

include'db_connect.php';

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $action = isset($_GET["action"]) ? sanitize_input($_GET["action"]) : '';
    $id = isset($_GET["id"]) ? sanitize_input($_GET["id"]) : '';

    if ($action === "delete_appointment") {
       
        $sql = "DELETE FROM appointment WHERE appointment_id  = '$id'";
        $conn->query($sql);
        echo "<script>
                alert('appointment record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'baola.php?page=appointment';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    } elseif ($action === "delete_billing"){
        $sql = "DELETE FROM billing WHERE Billing_id  = '$id'";
        $conn->query($sql);
        echo "<script>
                alert('billing record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'baola.php?page=billing';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    }elseif ($action === "delete_drugs"){
        $sql = "DELETE FROM drug WHERE Drug_id  = '$id'";
        $conn->query($sql);
        echo "<script>
                alert('drug record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'baola.php?page=drugs';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    }elseif ($action === "delete_patient"){
        $sql = "DELETE FROM test WHERE Patient_Id = '$id'";
        $conn->query($sql);
        echo "<script>
        alert('Test record deleted successfully.');
        setTimeout(function() {
            window.location.href = 'baola.php?page=patient';
        }, 200); // 1000 milliseconds = 3 seconds
    </script>";
    }elseif ($action === "delete_prescription"){
        $sql = "DELETE FROM prescription WHERE Prescription_id = '$id'";
        $conn->query($sql);
        echo "<script>
                alert('Prescription record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'baola.php?page=prescription';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    }elseif ($action === "delete_test"){
        $sql = "DELETE FROM test WHERE Test_id = '$id'";
        $conn->query($sql);
        echo "<script>
        alert('Test record deleted successfully.');
        setTimeout(function() {
            window.location.href = 'baola.php?page=test';
        }, 200); // 1000 milliseconds = 3 seconds
    </script>";
    }elseif ($action === "delete_user"){
        $sql = "DELETE FROM users WHERE id = '$id'";
        $conn->query($sql);
        echo "<script>
                alert('user record deleted successfully.');
                setTimeout(function() {
                    window.location.href = 'baola.php?page=user_list';
                }, 200); // 1000 milliseconds = 3 seconds
            </script>";
    }
     else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }
    

    $conn->close();
}
?>
//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE