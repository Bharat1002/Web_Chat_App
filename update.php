<?php 
  session_start();
  include_once "php/config.php";

?>

<?php include_once "header.php"; include_once "php/style.php"; ?>
<body class="update-body">
  <div class="wrapper update-wrapper">
    <section class="users">
    <header>
        <div class="content">
          <?php 
            $sql = $conn -> query("CALL spUsersDetails({$_SESSION['unique_id']})");
            if($sql -> num_rows > 0){
              $row = $sql -> fetch_assoc();
            }
          ?>
          <img src="php/images/<?php echo $row['img']; ?>" style="<?php echo $my_img; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <p>
                <i class="fas fa-circle" style="font-size: 12px; color: #468669; padding-left: 10px;"></i>
                <?php echo $row['status']; ?>
            </p>
          </div>
        </div>
      </header>
    </section>
    <!-- <section class="users"> -->
    <header>
            <span style="margin-left: 30px; margin-bottom: 0px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; outline: none">Update Your Details</span>
      </header>
    <!-- </section> -->
    <section class="form signup">
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo $row['fname']; ?>">
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" value="<?php echo $row['lname']; ?>">
          </div>
        </div>
        <div class="field image">
          <label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
        </div>
        <div class="field button" style="display: flex; align-items: stretch;">
          <input type="submit" class="update" style="width:40%;" name="submit" value="Update Details">
        </div>
      </form>
      <input type="submit" class="back" style="<?php echo $backbtn; ?>" name="Back" value="Back To Chat">

    </section>
  </div>
    
  <script src="javascript/update.js"></script>

</body>
</html>
