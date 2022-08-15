<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    $set_state = "CALL spReadStatus({$_SESSION['unique_id']},{$_SESSION['user_id']})";
    $set_query = $conn -> query($set_state);
    
}


?>