<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $sql = "CALL spShowUser({$outgoing_id})";
    $query = $conn -> query($sql);

    function clearResult($con){
        while($con -> next_result()){
            if($result = $con -> store_result()){
                $result -> free();
            }
        }
    }

    clearResult($conn);

    $grpquery = $conn -> query("CALL spShowGroup({$_SESSION['unique_id']})");
    $output = "";


    clearResult($conn);
    $grpoutput = "";


    if($query -> num_rows == 0 && $grpquery -> num_rows == 0){
        // $output .= "No users are available to chat";
    }else if($grpquery -> num_rows != 0) {
        include_once "grpdata.php";
    }
    echo $grpoutput;
?>