<div class="wrapper chat-wrapper">
    <section class="chat-area">
      <header style="height: 75px;">
        <?php

          if(!isset($_GET['user_id'])){
            $user_id = 0;
          } else {
            $user_id = $conn -> real_escape_string($_GET['user_id']);
          }
          clearResult($conn);
          $_SESSION['user_id'] = $user_id;

          $chatsql = $conn -> query("CALL spUsersDetails({$user_id})");
          clearResult($conn);
          $grpsql = $conn -> query("CALL spGroupAdmins({$user_id})");
          clearResult($conn);
          if($chatsql -> num_rows > 0){
            $chatrow = $chatsql -> fetch_assoc();
        ?>
        <!-- <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a> -->
        <img src="php/images/<?php echo $chatrow['img']; ?>" alt="">
        <div class="details chat-details">
          <span><?php echo $chatrow['fname']. " " . $chatrow['lname'] ?></span>
          <p></p>
        </div>
        <?php
         }else if($grpsql -> num_rows > 0){
          $grprow = $grpsql -> fetch_assoc();
        ?>

        <img src="php/images/<?php echo $grprow['img_name']; ?>" alt="">
        <div class="details">
          <span><?php echo $grprow['group_name'] ?></span>
          <p></p>
        </div>
        <?php
          if($_SESSION['unique_id'] == $grprow['admin_id']){ ?>
            <a href="adduser.php" class="back-icon" style="display: flex; justify-content: flex-end;
                                        align-items: center; margin-left: 80%;">
                <i class='fas fa-plus'></i>
            </a>
          <?php } ?>

        <?php
        } else {

        }
        ?>
      </header>
      <?php
      if($_SESSION['user_id']){
      ?>
      <div class= "chat-box" >
        

      </div>

      <form action="#" class="typing-area" style="">
        <?php include_once "php/style.php"; ?>
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <label for="file" <?php echo $input_style ?>>
        <i class="fas fa-ellipsis-h" style="opacity:0.8;width:55px;"></i>
        </label>
        <input type="file" id="file" name="file" class="file-field" style="display:none">
        <button id="button"><i class="fab fa-telegram-plane"></i></button>
      </form>
      <?php

      } else { ?>
            <div class= "chat-box" >
            <div class="text">Select User To Start Chat</div>

            </div>
      <?php
      }
      ?>
    </section>
</div>
