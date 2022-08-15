<?php
    session_start();
    include_once "config.php";
    $fname = $conn -> real_escape_string($_POST['fname']);
    $lname = $conn -> real_escape_string($_POST['lname']);
    $email = $conn -> real_escape_string($_POST['email']);
    $password = $conn -> real_escape_string($_POST['password']);
    function clearResult($con){
        while($con -> next_result()){
            if($result = $con -> store_result()){
                $result -> free();
            }
        }
    }
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = $conn -> query("CALL spCheckMail('{$email}')");
            // $sql = $conn -> query("SELECT * FROM users WHERE email='{$email}'");
            // echo "last";
            // exit;
            clearResult($conn);
            if($sql -> num_rows > 0){
                echo "$email - This email already exist!";
            }else{
                if(isset($_FILES['image'])){
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time();
                            $new_img_name = $time.$img_name;
                            if(move_uploaded_file($tmp_name,"./images/".$new_img_name)){
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                $insert_query = $conn -> query("CALL spInsertUser({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                clearResult($conn);
                                if($insert_query){
                                    $select_sql2 = $conn -> query("CALL spCheckMail('{$email}')");
                                    if($select_sql2 -> num_rows > 0){
                                        $result = $select_sql2 -> fetch_assoc();
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    } else{
                                        echo "This email address not Exist!";
                                    }
                                } else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>
