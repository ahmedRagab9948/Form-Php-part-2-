<?php 
ob_start();
session_start();
require_once "connect_db.php";
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["f_name"]) && !empty($_POST["s_name"]) && !empty($_POST["email"]) && !empty($_POST["phone"])){
    $first_name = filter_var($_POST["f_name"],FILTER_SANITIZE_STRING);
    $second_name = filter_var($_POST["s_name"],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST["phone"],FILTER_SANITIZE_NUMBER_INT);
    // create form errors
    $formErrors = array();
    if(strlen($first_name) < 3){
        $formErrors[] = "The First Name Must Be Larger Than <strong>3</strong> Characters";
    }
    if(strlen($second_name) < 3){
        $formErrors[] = "The Last Name Must Be Larger Than <strong>3</strong> Characters";
    }

    
    
    $image = $_FILES["user_img"]["name"];
    $size = $_FILES["user_img"]["size"];
    $tmp_name = $_FILES["user_img"]["tmp_name"];
    $type = $_FILES["user_img"]["type"];

    
    
    $extention_allowed = array("png","jpg","jpeg");
    
    
    @$extention             = strtolower(end(explode(".",$image)));
    global $avatar;
    if(in_array($extention,$extention_allowed)){
        $avatar = rand(0,1000000) . "_" . $image ;
        $destination = "img/" . $avatar ;
        move_uploaded_file($tmp_name,$destination);
      }else{
        $formErrors[] = "Sorry Extention Of The Photo Is Not Allowed";
      }


      
      $_SESSION["f_name"] = $first_name;
      $_SESSION["s_name"] = $second_name;
      $_SESSION["email"] = $email;
      $_SESSION["phone"] = $phone;
      $_SESSION["image"] = $avatar;



    if(empty($formErrors)){
      global $con;
      $stmt = $con->prepare("INSERT INTO `client_info` (`first_name`, `last_name`, `email`, `phone`, `img_name`) VALUES ('$first_name', '$second_name', '$email', '$phone', '$avatar')");
      $stmt->execute(array(
        ":first_name" => $first_name,
        ":last_name" => $second_name,
        ":email" => $email,
        ":phone" => $phone,
        ":img_name" => $avatar
    ));
      echo "<script>alert('GOOD!Your data has been saved successfully.')</script>";
      header("Refresh:1;url=profile.php");
    }

    
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/index.css" />
  </head>
  <body>
    <div class="overlay"></div>
    <!-- start frist-form -->
    <div class="frist-form">
      <div class="container pb-5">
        <h1 class="text-center">Registration Form</h1>
        <form action="login.php" method="POST" enctype="multipart/form-data">
            <?php if(isset($formErrors)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php
                    foreach($formErrors as $error){
                        echo $error . "<br/>";
                    }
                ?>
            </div>
            <?php } ?>
          <div class="form-row">
            <div class="form-group col-12">
              <label>First Name</label>
              <input
                type="text"
                placeholder="First Name"
                class="form-control"
                name="f_name"
                value="<?php if(isset($first_name)){echo $first_name;} ?>"
                required
              />
            </div>
            <div class="form-group col-12">
              <label>Last Name</label>
              <input
                type="text"
                placeholder="Last Name"
                class="form-control"
                name="s_name"
                value="<?php if(isset($second_name)){echo $second_name;} ?>"
                required
              />
            </div>
            <div class="form-group col-12">
              <label>Email</label>
              <input type="email" placeholder="Email" class="form-control"
              name="email" 
              value="<?php if(isset($email)){echo $email;} ?>"
              required/>
            </div>
            <div class="form-group col-12">
              <label>Phone</label>
              <input type="number" placeholder="Phone" class="form-control" 
              name="phone"
              value="<?php if(isset($phone)){echo $phone;} ?>"
              required/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Uploude Your Image</label><br />
              <input class="img" type="file" name="user_img"/>
            </div>
          </div>
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>
    <!-- end frist-form -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
  </body>
</html>


<?php 

ob_end_flush();