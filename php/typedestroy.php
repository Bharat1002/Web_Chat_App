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

    $sql = $conn -> query("CALL spCheckTypeStatus({$_SESSION['unique_id']},{$_SESSION['user_id']})");
    clearResult($conn);
    if($sql -> num_rows > 0){
        $sql2 = $conn -> query("CALL spUpdateTypeStatus(0,{$_SESSION['unique_id']},{$_SESSION['user_id']})");
        clearResult($conn);
    } else {
        $sql3 = $conn -> query("CALL spSetTypeStatus({$_SESSION['unique_id']},{$_SESSION['user_id']},0)");
        clearResult($conn);
    }
}

?>