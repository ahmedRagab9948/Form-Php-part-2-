<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/profile.css" />
</head>
<body>
<div class="overlay"></div>
<div class="frist-form">
      <div class="container pb-5">
      <?php
            ob_start(); 
            session_start();
            if(!empty($_SESSION['f_name'])){?>
                <h1 class="text-center"><?php echo "Hello" . " " . $_SESSION['f_name'] . " " . $_SESSION['s_name']; ?></h1>
                <div class="photo text-center">
                    <img src="img/<?php echo  $_SESSION['image']?>" alt="image">
                </div>

                <h3><?php echo "First Name: ";?><span><?php echo $_SESSION['f_name'];?></span>
                </h3>
                <h3><?php echo "Last Name: ";?><span><?php echo $_SESSION['s_name'];?></span>
                </h3>
                <h3><?php echo "Email: ";?><span><?php echo $_SESSION['email'];?></span>
                </h3>
                <h3><?php echo "Phone: ";?><span class="num"><?php echo $_SESSION['phone'];?></span>
                </h3>
                
            <?php
            }else{
                header("Location:login.php");
            }
      ?>
            <a href="logout.php">logout</a>
      </div>
</div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
</body>
</html>


<?php


ob_end_flush();
?>