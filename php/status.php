<?php 
  session_start();
  include_once "config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>

<?php
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    function clearResult($con){
      while($con -> next_result()){
          if($result = $con -> store_result()){
              $result -> free();
          }
      }
  }
    $user_id = $_SESSION['user_id'];
    $sql = $conn -> query("CALL spUsersDetails({$user_id})");
    clearResult($conn);
    if($sql -> num_rows > 0){
        $row = $sql -> fetch_assoc();
        } else {
              
        }
        if ($row['status'] == "Active now"){
          echo '<i class="fas fa-circle" style="  font-size: 12px; color: #468669; padding-left: 10px; margin-right: 5px;">
                </i>'.$row['status'];
        } else {
          include_once "time.php";
          $lastdate = explode('-', $row['last_seenDate']);
          $crdate = explode('-',$date);
          $daydiff = abs($lastdate[2] - $crdate[2]);
          $lasttime = explode(':',$row['last_seenTime']);
          $crtime = explode(':', $time);

          if($row['last_seenDate'] == $date){
            $lastmin = ($lasttime[0]*60) + $lasttime[1];
            $crmin = ($crtime[0]*60) + $crtime[1];

            if(abs($lastmin - $crmin) < 60){
              $diff = abs($lastmin - $crmin);
              echo "last seen ". $diff . " min ago";
            } else {
                  echo "last seen today at " . $lasttime[0] . ":" . $lasttime[1];
            }
          } else {
            if($lastdate[0] == $crdate[0] && $lastdate[1] == $crdate[1]){
              if($daydiff == 1){
                echo "last seen yesterday at " . $lasttime[0] . ":" . $lasttime[1];
              } else if ($daydiff < 7){
                $timestamp = strtotime($row['last_seenDate']);
                $day = date('D', $timestamp);
                echo "last seen ". $day . " " . $lasttime[0] . ":" . $lasttime[1];
              } else {
                echo "last seen on " . $lastdate[2] ."-". $lastdate[1] . "-" . $lastdate[0] . " at " .  $lasttime[0] . ":" . $lasttime[1];
              }
            } else {
              echo "last seen on " . $lastdate[2] ."-". $lastdate[1] . "-" . $lastdate[0] . " at " .  $lasttime[0] . ":" . $lasttime[1];
            }
          }
        }    
} else{
    header("location: ../login.php");
}

?>