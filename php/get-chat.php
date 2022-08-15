<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        include_once "style.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $conn -> real_escape_string($_POST['incoming_id']);
        $output = "";
        function clearResult($con){
            while($con -> next_result()){
                if($result = $con -> store_result()){
                    $result -> free();
                }
            }
        }

        $sql = "CALL spChat({$outgoing_id},{$incoming_id})";
        $query = $conn -> query($sql);
        clearResult($conn);
        if($query -> num_rows > 0){
            while($row = $query -> fetch_assoc()){

                if($row['f_ile'] != NULL){
                    $file_explode = explode('.',$row['f_ile']);
                    $file_ext = end($file_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($file_ext, $extensions) === true){
                            $anc = '<a href="php/files/'.$row['f_ile'].'" style="color: red;">
                                    <img src="php/files/'.$row['f_ile'].'" style="'.$chat_img.'"></img>
                                    </a>';
                    }else {
                        $anc = '<a href="php/files/'.$row['f_ile'].'" style="color: red;">Open File</a>';
                    }
                } else {
                    $anc = '';
                }

                if($row['msg'] != NULL){
                    $msg = '<p>'. $row['msg'] .'</p>';
                } else {
                    $msg = '';
                }
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                    '. $msg .'
                                    '.$anc.'
                                    </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                    <img src="php/images/'.$row['img'].'" alt="">
                                    <div class="details">
                                    '. $msg .'
                                    '.$anc.'
                                    </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>