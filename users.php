<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  } else {
    $statusUpdate = $conn -> query("CALL spUpdateStatus({$_SESSION['unique_id']})");
  }
  function clearResult($con){
    while($con -> next_result()){
        if($result = $con -> store_result()){
            $result -> free();
        }
    }
}
?>
<?php include_once "header.php"; include_once "php/style.php"; ?>
<body>
  <div class="wrapper users-wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = $conn -> query("CALL spUsersDetails({$_SESSION['unique_id']})");
            clearResult($conn);
            if($sql -> num_rows > 0){
              $row = $sql -> fetch_assoc();
            }
          ?>
          <div style="position: relative;">
            <img src="php/images/<?php echo $row['img']; ?>" style="<?php echo $my_img ?>" alt="">
            <i class="fa fa-edit"></i>
          </div>
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <p>Active now</p>
          </div>
        </div>
        <i class="fas fa-users" ></i>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
      </header>
      <div class="search">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="column">
        <div class="grpusers-list" >
    
        </div>
        <div class="users-list">
    
        </div>
      </div>
    </section>
  </div>
  <?php include "chat.php"; ?>

  <script src="javascript/users.js"></script>
  <?php
    if($chatsql -> num_rows > 0){
  ?>
  <script src="javascript/chat.js"></script>
  <script src="javascript/status.js"></script>
  <script src="javascript/set_readstatus.js"></script>
<?php
    } else {
      ?>
  <script src="javascript/chatgrp.js"></script>
<?php } ?>
</body>
</html>
