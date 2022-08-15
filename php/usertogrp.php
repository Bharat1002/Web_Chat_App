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
clearResult($conn);
$query = "CALL spCheckMember({$_SESSION['user_id']},{$_SESSION['usr_add']})";
$checkquery = $conn -> query($query);

clearResult($conn);

if($checkquery -> num_rows > 0){
    header("location: ../adduser.php");
} else {
    $addquery = $conn -> query("CALL spAddMember({$_SESSION['user_id']},{$_SESSION['usr_add']})");
    clearResult($conn);
    if($addquery){
        header("location: ../users.php");
    } else {
        header("location: ../adduser.php");
    }
}

?>