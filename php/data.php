<?php


    while($row = $query -> fetch_assoc()){


        
        clearResult($conn);

        $sql2 = "CALL spDisplayUser({$row['unique_id']},{$outgoing_id})";
        $query2 = $conn -> query($sql2);
        $row2 = $query2 -> fetch_assoc();
        clearResult($conn);


        ($query2 -> num_rows > 0) ? $result = $row2['msg'] : $result ="No message available";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        ($row['status'] == "Active now") ? $offline = "online" : $offline = "offline";
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        clearResult($conn);

        $sqld = "CALL spCheckReadStatus({$_SESSION['unique_id']},{$row['unique_id']})";
        $var = $conn -> query($sqld);

        clearResult($conn);

        if($var){
            
            if($var -> num_rows > 0){
                $style = '<div style = "position: absolute;
                bottom: -3px;
                righleftt: -3px;
                cursor: pointer;
                border-radius: 50%;
                height: 20px;
                width: 20px;
                display: flex !important;
                align-items: center;
                justify-content: center;
                background-color: white;
                color: black;
                box-shadow: 0 0 8px 3px #b8b8b8;"
                >'.mysqli_num_rows($var).'</div>';
            } else {
                $style = '<div style = "none;"></div>';
            }
        } else {
            $style = '<div style = "none;"></div>';
        }

        $typing = $conn -> query("CALL spTypeStatus({$row['unique_id']},{$_SESSION['unique_id']})");

        clearResult($conn);
        $typ = '';

        if($typing){
            $type_status = $typing -> fetch_assoc();
            if($type_status){
                if($type_status['type_status'] == 1){
                    $typ = '<p>Typing...</p>';   
                } else {
                    // $typ = $you . $msg;
                }
            } else {
                // $typ = $you . $msg;
            }
        } else {
            // $typ = $you . $msg;
        }

        // echo $refresh;
        $output .= '<a href="users.php?user_id='. $row['unique_id'] .'" style="border-bottom-color: none; border: none;">
                        <div class="content" style="position: relative;">
                            <img src="php/images/'. $row['img'] .'" alt="">
                            '.$style .'
                            
                                <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i>
                                    <span class="user-span">'. $row['fname']. " " . $row['lname'] .'</span>
                                    '.$typ.'
                                </div>  
                           
                        </div>
                    </a>';


    }
?>
 