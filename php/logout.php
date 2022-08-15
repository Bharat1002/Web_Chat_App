<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        include_once "time.php";
        function clearResult($con){
            while($con -> next_result()){
                if($result = $con -> store_result()){
                    $result -> free();
                }
            }
        }
        $logout_id = $conn -> real_escape_string($_GET['logout_id']);
        if(isset($logout_id)){
            $sql = $conn -> query("CALL spSetStatus('{$time}',{$_GET['logout_id']})");
            clearResult($conn);
            if($sql){
                $sqlTime = $conn -> query("CALL spLastSeen('{$time}','{$date}',{$_SESSION['unique_id']})");
                clearResult($conn);
                if($sqlTime){
                    session_unset();
                    session_destroy();
                    header("location: ../login.php");
                }
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>