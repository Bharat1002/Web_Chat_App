<?php
    session_start();
    include_once "config.php";
    $gname = $conn -> real_escape_string($_POST['gname']);
    function clearResult($con){
        while($con -> next_result()){
            if($result = $con -> store_result()){
                $result -> free();
            }
        }
    }

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
            $ran_id = rand(time(), 100000000);
            $new_img_name = $time.$img_name;
            if(move_uploaded_file($tmp_name,"./images/".$new_img_name)){            
                $insert_query = $conn -> query("CALL spCreateGroup('{$gname}',{$ran_id},{$_SESSION['unique_id']},'{$new_img_name}')");
                clearResult($conn);
                if($insert_query){
                   $addself = $conn -> query("CALL spAddMember({$ran_id},{$_SESSION['unique_id']})");
                   clearResult($conn);
                   if($addself){
                       echo "success";
                   }
                } else{
                        echo "This address not Exist!";
                    }
                }
            }
        }
    }
?>