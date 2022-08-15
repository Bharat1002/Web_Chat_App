<?php 
    session_start();
    include_once "config.php";
    function clearResult($con){
        while($con -> next_result()){
            if($result = $con -> store_result()){
                $result -> free();
            }
        }
    }
    $email = $conn -> real_escape_string($_POST['email']);
    $password = $conn -> real_escape_string($_POST['password']);
    if(!empty($email) && !empty($password)){
        $sql = $conn -> query("CALL spCheckMail('{$email}')");
        clearResult($conn);
        if($sql -> num_rows > 0){
            $row = $sql -> fetch_assoc();
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                $status = "Active now";
                $sql2 = $conn -> query("CALL spSetStatus('{$status}',{$row['unique_id']})");
                clearResult($conn);
                if($sql2){
                    $_SESSION['unique_id'] = $row['unique_id'];
                    $_SESSION['user_id'] = 0;
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$email - This email not Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
?>