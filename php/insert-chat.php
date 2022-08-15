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
        clearResult($conn);
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $conn -> real_escape_string($_POST['incoming_id']);
        clearResult($conn);
        $message = $conn -> real_escape_string($_POST['message']);
        clearResult($conn);
        if(isset($_FILES['file'])){
            $file_name = $_FILES['file']['name'];
            $file_type = $_FILES['file']['type'];
            $tmp_name = $_FILES['file']['tmp_name'];
            if(!empty($file_name)){
                $read_count = 1;
                if(!empty($message)){
                    $time = time();
                    $new_file_name = $time.$file_name;
                    if(move_uploaded_file($tmp_name,"./files/".$new_file_name)){
                        $sql = $conn -> query("CALL spInsertFileChat({$incoming_id},{$outgoing_id},
                                                '{$message}','{$new_file_name}',{$read_count})");
                        clearResult($conn);
                        if(!$sql){
                            if(!empty($message)){
                                $sql = $conn -> query("CALL spInsertChat({$incoming_id},{$outgoing_id},'{$message}',{$read_count})");
                                clearResult($conn);
                            }
                        }
                    }
                } else {
                    $time = time();
                    $new_file_name = $time.$file_name;
                    if(move_uploaded_file($tmp_name,"./files/".$new_file_name)){
                        $sql = $conn -> query("INSERT INTO messages(incoming_msg_id, outgoing_msg_id, f_ile, read_state)
                                            VALUES({$incoming_id},{$outgoing_id},'{$new_file_name}',{$read_count})");
                    }
                }
                // $file_explode = explode('.',$file_name);
                // $file_ext = end($file_explode);

                // $extensions = ["jpeg", "png", "jpg"];
                // if(in_array($file_ext, $extensions) === true){
                //     $types = ["image/jpeg", "image/jpg", "image/png"];
                //     if(in_array($file_type, $types) === true){

                //         }
                //     }
                // } 
            } else {
                $read_count = 1;
                if(!empty($message)){
                    $sql = $conn -> query("CALL spInsertChat({$incoming_id},{$outgoing_id},'{$message}',{$read_count})");
                    clearResult($conn);
                }
            } 
        } else {
            $read_count = 1;
            if(!empty($message)){
                $sql = $conn -> query("CALL spInsertChat({$incoming_id},{$outgoing_id},'{$message}',{$read_count})");
                clearResult($conn);
            }
        }

    }else{
        header("location: ../login.php");
    }  
?>