<?php


    while($grprow = $grpquery -> fetch_assoc()){
        // $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
        //         OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
        //         OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        // $query2 = mysqli_query($conn, $sql2);
        // $row2 = mysqli_fetch_assoc($query2);


        clearResult($conn);


        // $grprow = mysqli_fetch_assoc($grpquery);
        // if($grprow){    
            $grpquery2 = $conn -> query("CALL spGroupData({$grprow['group_id']})");
            clearResult($conn);
            $grprow2 = $grpquery2 -> fetch_assoc();
        // }



        // (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        // (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        // if(isset($row2['outgoing_msg_id'])){
        //     ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        // }else{
        //     $you = "";
        // }
        // ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        // ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        
        // $sqld = "SELECT * FROM messages WHERE incoming_msg_id = {$_SESSION['unique_id']} AND 
        //         outgoing_msg_id = {$row['unique_id']} AND read_state = 1";
        // $var = mysqli_query($conn, $sqld);

        // if($var){
        //     if(mysqli_num_rows($var) > 0){
        //         $style = '<div style = "width: 20px;
        //         height: 20px;
        //         border-radius: 50%;
        //         color: black;
        //         position: absolute;
        //         right: 0;
        //         bottom: 0;
        //         text-align: center;
        //         background-color: orange;"
        //         >'.mysqli_num_rows($var).'</div>';
        //     } else {
        //         $style = '<div style = "none;"></div>';
        //     }
        // } else {
        //     $style = '<div style = "none;"></div>';
        // }

        // $typing = mysqli_query($conn, "SELECT * FROM typeStatus
        //                                 WHERE sender_id={$row['unique_id']}
        //                                 AND receiver_id={$_SESSION['unique_id']}");
        // if($typing){
        //     $type_status = mysqli_fetch_assoc($typing);
        //     if($type_status){
        //         if($type_status['type_status'] == 1){
        //             $typ = "Typing...";   
        //         } else {
        //             $typ = $you . $msg;
        //         }
        //     } else {
        //         $typ = $you . $msg;
        //     }
        // } else {
        //     $typ = $you . $msg;
        // }


        $grpoutput .= '<a href="users.php?user_id='. $grprow2['group_id'] .'">
                        <div class="content" style="position: relative;">
                        <img src="php/images/'. $grprow2['img_name'] .'" alt="">
                        <div class="details">
                            <span>'. $grprow2['group_name'] .'</span>
                        </div>
                        </div>
                    </a>';


    }
?>
 