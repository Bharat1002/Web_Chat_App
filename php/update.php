<?php
    session_start();

    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        function clearResult($con){
            while($con -> next_result()){
                if($result = $con -> store_result()){
                    $result -> free();
                }
            }
        }

        $imgsql = $conn -> query(" CALL spUsersDetails({$_SESSION['unique_id']})");

        clearResult($conn);

        $old_data = $imgsql -> fetch_assoc();
        $old_img = $old_data['img'];

        $fname = $conn -> real_escape_string($_POST['fname']);
        $lname = $conn -> real_escape_string($_POST['lname']);
        
        if((isset($_FILES['image']))){
            $img_name = $_FILES['image']['name'];  
                    
            if(!empty($img_name)){
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
                            if(unlink("./images/" . $old_img)){
                                if(!empty($fname) && !empty($lname)){
                                    $update_sql = $conn -> query("CALL spUpdateUser('{$fname}','{$lname}','{$new_img_name}',
                                                                    {$_SESSION['unique_id']})");
                                    clearResult($conn);
                                    if($update_sql){
                                        echo "success";
                                    }
                                }
                            } else {
                                if(!empty($fname) && !empty($lname)){
                                    $update_sql = $conn -> query("CALL spUpdateUser('{$fname}','{$lname}','{$new_img_name}',
                                                                    {$_SESSION['unique_id']})");
                                    clearResult($conn);;
                                    if($update_sql){
                                        echo "success";
                                    }
                                }
                            }
                        }
                    } else {
                        echo "invalid img!";
                    }
                } else {
                    echo "invalid img!";
                }
            }else {
                if(!empty($fname) && !empty($lname)){
                    $update_sql = $conn -> query("CALL spUpdateUser('{$fname}','{$lname}','{$old_img}',
                                                    {$_SESSION['unique_id']})");
                    clearResult($conn);
                    if($update_sql){
                        echo "success";
                    } else {
                        echo "img fail5";
                    } 
                }else {
                    echo "something went wrong";
                }
            }
        }
    }
    ?>