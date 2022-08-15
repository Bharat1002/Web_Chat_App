<?php
session_start();
include "php/config.php";
include "header.php";
?>
<body class="update-body">
    <?php
    function clearResult($con){
        while($con -> next_result()){
            if($result = $con -> store_result()){
                $result -> free();
            }
        }
    }
    $cquery = "CALL spCheckAdmin({$_SESSION['user_id']},{$_SESSION['unique_id']})";
    $csql = $conn -> query($cquery);
    clearResult($conn);
    if($csql -> num_rows > 0){

    ?>
<section class="users">
    <div class="search">
        <span class="text">Select an user to add</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
    </div>
    <?php include_once "php/style.php"; ?>
    <div class="users-list">
  
    </div>
    <input type="submit" class="back" style="<?php echo $backbtn; ?>" name="Back" value="Cancel">
</section>

<script src="javascript/adduser.js"></script>
<?php 
    } else {
        header("location: users.php");
    }
?>
</body>
</html>