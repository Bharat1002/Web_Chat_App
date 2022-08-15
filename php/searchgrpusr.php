<?php
    session_start();
    include_once "config.php";

    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = $conn -> real_escape_string($_POST['searchTerm']);

    function clearResult($con){
        while($con -> next_result()){
            if($result = $con -> store_result()){
                $result -> free();
            }
        }
    }

    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = $conn -> query($sql);
    clearResult($conn);
    if($query -> num_rows > 0){
        include_once "datausradd.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>