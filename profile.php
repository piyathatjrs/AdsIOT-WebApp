<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
?>
<?php
require("./DB/config.php");
$usernames = $_SESSION['username'];
// ::: select :::
$sql = "SELECT * FROM users where username = '$usernames'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
  $id[] = $row['id'];
  $username[] = $row['username'];
  $created_at[] = $row['created_at'];
  $firstname[] = $row['firstname'];
  $lastname[] = $row['lastname'];
  $place_use[] = $row['place_use'];
  $password[] = $row['password'];
  $line_id[] = $row['line_id'];
  $line[] =$row['line'];
}


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// $new_password = $confirm_password = "";
// $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if (empty($username_err) && empty($password_err)) {
    // Prepare a select statement
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = $username;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {

              $new_password = $confirm_password = "";
              $new_password_err = $confirm_password_err = "";

              // Processing form data when form is submitted
              if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Validate new password
                if (empty(trim($_POST["new_password"]))) {
                  $new_password_err = "Please enter the new password.";
                } elseif (strlen(trim($_POST["new_password"])) < 6) {
                  $new_password_err = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
                } else {
                  $new_password = trim($_POST["new_password"]);
                }
                // Validate confirm password
                if (empty(trim($_POST["confirm_password"]))) {
                  $confirm_password_err = "Please confirm the password.";
                } else {
                  $confirm_password = trim($_POST["confirm_password"]);
                  if (empty($new_password_err) && ($new_password != $confirm_password)) {
                    $confirm_password_err = "โปรดใส่รหัสผ่านให้ตรงกัน";
                  }
                }
                // Check input errors before updating the database
                if (empty($new_password_err) && empty($confirm_password_err)) {
                  // Prepare an update statement
                  $sql = "UPDATE users SET password = ? WHERE id = ?";

                  if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

                    // Set parameters
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $param_id = $_SESSION["id"];

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                      // Password updated successfully. Destroy the session, and redirect to login page
                      session_destroy();
                      header("location: http://localhost/project/Login_v16/index_login.php");
                      exit();
                    } else {
                      echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                  }
                }

                // Close connection
                mysqli_close($link);
              }
            } else {
              // Display an error message if password is not valid
              $password_err = "<center><span><i style='color:red'>รหัสผ่านที่คุณป้อนไม่ถูกต้อง</i></span></center>";
            }
          }
        } else {
          // Display an error message if username doesn't exist
          $username_err = "<center><span><i style='color:red'>ไม่พบบัญชีผู้ใช้</i></span></center>";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      //Check input errors before updating the database

    }
  }
}

require("process_mqtt_send.php");
?>




<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>จัดการโปรไฟล์</title>
  <link rel="shortcut icon" type="image/x-icon" href="./images/user.png" />

  <script src="script.js"></script>
  <script src="https://dribbble.com/shots/2536070-Jelly-Buttons-CSS"></script>



</head>

<body>
  <nav class="navs">
    <div class="container-fluid">
      <div class="logo">
        <img src="./images/title.png" alt="" style="width:65%">
      </div>
      <div id="mainListDiv" class="main_list">
        <ul class="navlinks">

          <?php
          if ($_SESSION["loggedin"] == true) {
            echo " <li><a href='welcome.php'>หน้าแรก</a></li>";
          }
          ?>
          <?php
          if ($_SESSION["loggedin"] == true) {
            echo "  <li><a href='http://localhost/project/report.php'>รายงาน</a></li>";
          }
          ?>
          <?php
          if ($_SESSION["loggedin"] == true) {
            echo "  <li><a href='profile.php'>ข้อมูลส่วนตัว</a></li>";
          }
          ?>
             <?php
                    if ($_SESSION["loggedin"] == true) {
                      echo '   <li><a style="cursor:pointer"><div data-toggle="modal" data-target="#modalLoginAvatar_line"><span>เชื่อมต่อLINE</span></div></a></li>';
             
                    }
                    ?>
          <?php
          if ($_SESSION["loggedin"] == true) {
            echo "  <li><a href='logout.php'>ออกจากระบบ</a></li>";
          }
          ?>
          <?php
          if ($_SESSION["loggedin"] != true) {
            echo " <li><a href='register.php'>สมัครสมาชิก</a></li>";
          }
          ?>
          <?php
          if ($_SESSION["loggedin"] != true) {
            echo "  <li><a href='login.php'>เข้าสู่ระบบ</a></li>";
          }
          ?>
        </ul>
      </div>
      <span class="navTrigger">
        <i></i>
        <i></i>
        <i></i>
      </span>
    </div>
  </nav>
  <section class="home">


  <center><div class="container-fluid profile">
  <div class="row">
    <div class="col-sm">
    <div class="text-center">
          <img src="./images/user.png" class="avatar img-circle img-thumbnail" alt="avatar" height="220px" width="220px">
          <br><label style="font-size:20px" for="">สวัสดี</label> <label  style="font-size:15px;color:dodgerblue"  for=""><?php echo $firstname[0]." ".$lastname[0]?></label>
        </div>
    </div>
    <div class="col-sm">
    <form class="form" action="process_update_user.php" method="post" id="registrationForm">
              <div class="form-group">
                <div class="col-xs-6">
                  <label for="first_name">
                    <h4>ชื่อจริง</h4>
                  </label>
                  <input type="text" class="form-control" name="firs_name" id="first_name" placeholder="ชื่อจริง" value="<?php echo $firstname[0]; ?>" title="enter your first name if any.">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-6">
                  <label for="last_name">
                    <h4>นามสกุล</h4>
                  </label>
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="นามสกุล" value="<?php echo $lastname[0]; ?>" title="enter your last name if any.">
                </div>
              </div>
              <div class="form-group">

                <div class="col-xs-6">
                  <label for="email">
                    <h4>อีเมล</h4>
                  </label>
                  <input type="email" class="form-control" name="email" id="email" value="<?php echo $_SESSION['username']; ?>" title="enter your email." disabled>
                </div>
              </div>
              <div class="form-group">

                <div class="col-xs-6">
                  <label for="email">
                    <h4>สถานที่</h4>
                  </label>
                  <input type="text" class="form-control" id="location" name='place' placeholder="สถานที่" value="<?php echo $place_use[0] ?>" title="enter a location">
                </div>
              </div>

              <div class="form-group">

                <div class="col-xs-6">
                  <label for="password2">
                    <h4>เป็นสมาชิกเมื่อ</h4>
                  </label>
                  <input type="text" class="form-control" name="password2" id="password2" value="<?php echo $created_at[0] ?>" title="enter your password2." disabled>
                </div>
              </div>

              

              <div class="form-group">

<div class="col-xs-6">
  <label for="password2">
    <h4>รายละเอียด</h4>
  </label>
  <textarea   type="text"class="form-control" 
    id="line_id" 
    name="line_id" 
    maxlength="" /><?php echo $line_id[0] ?></textarea>
 </div>
</div>
              <div class="form-group">
                <div class="col-xs-12">
                  <br>
                  <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i>บันทึก</button>
                  &nbsp;<button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i>รีเซ็ต</button>
                </div>
              </div>
            </form>


    </div>
    <div class="col-sm">
     

    <div style="padding-top:20px" class="wrapper">
              <h2>เปลี่ยนรหัสผ่าน</h2>
              <h6>กรุณากรอกแบบฟอร์มนี้เพื่อเปลี่ยนรหัสผ่านของคุณ</h6>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" style="display: none;">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['username']; ?>">
                  <span class="help-block"><?php echo $username_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label>รหัสผ่านเดิม</label>
                  <input type="password" name="password" class="form-control" required placeholder="รหัสผ่านเดิม">
                  <span class="help-block"><?php echo $password_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                  <label>รหัสผ่านใหม่</label>
                  <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>" required placeholder="รหัสผ่านใหม่">
                  <span class="help-block"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                  <label>ยืนยันรหัสผ่านใหม่</label>
                  <input type="password" name="confirm_password" class="form-control" required placeholder="ยืนยันรหัสผ่าน">
                  <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>


                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="ตกลก">
                  <a class="btn btn-link" href="http://localhost/project/">ยกเลิก</a>
                </div>
              </form>
            </div>


    </div>
  </div>
</div></center>


    
  </section>

  <div style="padding-top:80px; " class="modal fade" id="modalLoginAvatar_line" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

                <div class="modal-content" style="border-radius: 10px;">
                    <div style="padding-left:17%" class="modal-header">
                        <center><img src="./images/Qrcode_Linebot.png" height="220px" width="100%" alt="avatar" class="img-responsive">
                        <p>@137nmroa</p>
                    </center>
                    </div>
                    <form action="add_line.php" method="POST">
                        <div class="modal-body text-center mb-1">
                            <h1 class="mt-1 mb-2">LINE</h1>
                            <?php 
                                    if($line[0] == null){
                                        echo "<h3 style='color:red'>ท่านยังไม่ได้เชื่อมต่อ</h3>";
                                    }else {
                                        echo "<h5 style='color:green'>เชื่อมต่อแล้ว</h5>";
                                    }
                            ?>

                            <input type="text" value="Add" name="type" hidden>
                            <div class="md-form ml-0 mr-0">
                                <!-- <input autocomplete="off" style="height:30px; font-size:20px ;" name='uid' type="text" type="text" id="form29" class="form-control form-control-sm validate ml-0" placeholder="รหัส" minlength="32" maxlength="32" required> -->
                            </div>
                            <div class="text-center mt-4">
                                <!-- <button name='username' class="btn btn-cyan mt-1" value=<?php echo $_SESSION['username']; ?>>
                                    <h2>เพิ่ม</h2>
                            
                                </button> -->
                                <h5 > หมายเหตุ : หากต้องการเปลี่ยนไลน์ หรือ เริ่มการใช้งานในการแจ้งเตือน "ดำเนินการผ่าน Application LINE " <br><span style="color:red">โดยพิมพ์ข้อความว่า "...."</span></h5>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

  <!-- Jquery needed -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Function used to shrink nav bar removing paddings and adding black background -->
  <script>
    $(window).scroll(function() {
      if ($(document).scrollTop() > 50) {
        $('.navs').addClass('affix');
        console.log("OK");
      } else {
        $('.navs').removeClass('affix');
      }
    });


    $('.navTrigger').click(function() {
      $(this).toggleClass('active');
      console.log("Clicked menu");
      $("#mainListDiv").toggleClass("show_list");
      $("#mainListDiv").fadeIn();

    });
  </script>
</body>

</html>

<style type="text/css">
  body {
    font: 14px sans-serif;
  }

 
</style>

<style>
  @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
  @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');

  .profile {
   padding: 200px 100px 0 30px;
    margin:0px;
    text-align: center;
    
  }

  .home {
    box-sizing: border-box;
    font-family: 'Mitr', sans-serif;
  }
  h4, h2, label ,h6{
    color:#fff;
  }


  .wording {
    font-size: 50px;
    padding-top: 15%;
    color: #fff;
    width: 30%;
    height: 200px;
    text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.55);
  }

  .wel {
    margin-left: 10%;
    padding-top: 15%;
  }

  .button {
    height: 20%;
    width: 10%;
  }

  /*******************************************************************/


  .pro {
    padding: 5px;
    padding-top: 100px;

  }



  html,
  body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Mitr', sans-serif;
    font-size: 62.5%;
    font-size: 10px;
  }

  /*-- Inspiration taken from abdo steif -->
/* --> https://codepen.io/abdosteif/pen/bRoyMb?editors=1100*/
  /* Navbar section */
  .navs {
    width: 100%;
    height: 65px;
    position: fixed;
    line-height: 65px;
    text-align: center;
    z-index: 2048;
  }

  .navs div.logo {
    float: left;
    width: auto;
    height: auto;
    padding-left: 0rem;
    margin-left: -60pX;
  }

  .navs div.logo a {
    text-decoration: none;
    color: #fff;
    font-size: 2.5rem;
  }

  .navs div.logo a:hover {
    color: #00E676;
  }

  .navs div.main_list {
    height: 65px;
    float: right;
  }

  .navs div.main_list ul {
    width: 100%;
    height: 65px;
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .navs div.main_list ul li {
    width: auto;
    height: 65px;
    padding: 0;
    padding-right: 3rem;
  }

  .navs div.main_list ul li a {
    text-decoration: none;
    color: #fff;
    line-height: 65px;
    font-size: 2.4rem;
  }

  .navs div.main_list ul li a:hover {
    color: #00E676;
  }

  /* Home section */
  .home {
    width: 100%;
    height: 100%;
 background-image: url('./images/bg33.jpg');
    background-position: center top;
    background-size: cover;
    border: 0cm;  
  }


  .navTrigger {
    display: none;
  }

  .navs {
    padding-top: 20px;
    padding-bottom: 20px;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
  }

  /* Media qurey section */
  @media screen and (min-width: 768px) and (max-width: 1024px) {
    .container {
      margin: 0;
    }
  }

  @media screen and (max-width:768px) {
    .navTrigger {
      display: block;
    }

    .navs div.logo {
      margin-left: 15px;
    }

    .navs div.main_list {
      width: 100%;
      height: 0;
      overflow: hidden;
    }

    .navs div.show_list {
      height: auto;
      display: none;
    }

    .navs div.main_list ul {
      flex-direction: column;
      width: 100%;
      height: 100vh;
      right: 0;
      left: 0;
      bottom: 0;
      background-color: #111;
      /*same background color of navbar*/
      background-position: center top;
    }

    .navs div.main_list ul li {
      width: 100%;
      text-align: right;
    }

    .navs div.main_list ul li a {
      text-align: center;
      width: 100%;
      font-size: 3rem;
      padding: 20px;
    }

    .navs div.media_button {
      display: block;
    }
  }

  /* Animation */
  /* Inspiration taken from Dicson https://codemyui.com/simple-hamburger-menu-x-mark-animation/ */
  .navTrigger {
    cursor: pointer;
    width: 30px;
    height: 25px;
    margin: auto;
    position: absolute;
    right: 30px;
    top: 0;
    bottom: 0;
  }

  .navTrigger i {
    background-color: #fff;
    border-radius: 2px;
    content: '';
    display: block;
    width: 100%;
    height: 4px;
  }

  .navTrigger i:nth-child(1) {
    -webkit-animation: outT 0.8s backwards;
    animation: outT 0.8s backwards;
    -webkit-animation-direction: reverse;
    animation-direction: reverse;
  }

  .navTrigger i:nth-child(2) {
    margin: 5px 0;
    -webkit-animation: outM 0.8s backwards;
    animation: outM 0.8s backwards;
    -webkit-animation-direction: reverse;
    animation-direction: reverse;
  }

  .navTrigger i:nth-child(3) {
    -webkit-animation: outBtm 0.8s backwards;
    animation: outBtm 0.8s backwards;
    -webkit-animation-direction: reverse;
    animation-direction: reverse;
  }

  .navTrigger.active i:nth-child(1) {
    -webkit-animation: inT 0.8s forwards;
    animation: inT 0.8s forwards;
  }

  .navTrigger.active i:nth-child(2) {
    -webkit-animation: inM 0.8s forwards;
    animation: inM 0.8s forwards;
  }

  .navTrigger.active i:nth-child(3) {
    -webkit-animation: inBtm 0.8s forwards;
    animation: inBtm 0.8s forwards;
  }

  @-webkit-keyframes inM {
    50% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(45deg);
    }
  }

  @keyframes inM {
    50% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(45deg);
    }
  }

  @-webkit-keyframes outM {
    50% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(45deg);
    }
  }

  @keyframes outM {
    50% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(45deg);
    }
  }

  @-webkit-keyframes inT {
    0% {
      -webkit-transform: translateY(0px) rotate(0deg);
    }

    50% {
      -webkit-transform: translateY(9px) rotate(0deg);
    }

    100% {
      -webkit-transform: translateY(9px) rotate(135deg);
    }
  }

  @keyframes inT {
    0% {
      transform: translateY(0px) rotate(0deg);
    }

    50% {
      transform: translateY(9px) rotate(0deg);
    }

    100% {
      transform: translateY(9px) rotate(135deg);
    }
  }

  @-webkit-keyframes outT {
    0% {
      -webkit-transform: translateY(0px) rotate(0deg);
    }

    50% {
      -webkit-transform: translateY(9px) rotate(0deg);
    }

    100% {
      -webkit-transform: translateY(9px) rotate(135deg);
    }
  }

  @keyframes outT {
    0% {
      transform: translateY(0px) rotate(0deg);
    }

    50% {
      transform: translateY(9px) rotate(0deg);
    }

    100% {
      transform: translateY(9px) rotate(135deg);
    }
  }

  @-webkit-keyframes inBtm {
    0% {
      -webkit-transform: translateY(0px) rotate(0deg);
    }

    50% {
      -webkit-transform: translateY(-9px) rotate(0deg);
    }

    100% {
      -webkit-transform: translateY(-9px) rotate(135deg);
    }
  }

  @keyframes inBtm {
    0% {
      transform: translateY(0px) rotate(0deg);
    }

    50% {
      transform: translateY(-9px) rotate(0deg);
    }

    100% {
      transform: translateY(-9px) rotate(135deg);
    }
  }

  @-webkit-keyframes outBtm {
    0% {
      -webkit-transform: translateY(0px) rotate(0deg);
    }

    50% {
      -webkit-transform: translateY(-9px) rotate(0deg);
    }

    100% {
      -webkit-transform: translateY(-9px) rotate(135deg);
    }
  }

  @keyframes outBtm {
    0% {
      transform: translateY(0px) rotate(0deg);
    }

    50% {
      transform: translateY(-9px) rotate(0deg);
    }

    100% {
      transform: translateY(-9px) rotate(135deg);
    }
  }

  .affix {
    padding: 0;
    background-color: #111;
  }

  .myH2 {
    text-align: center;
    font-size: 4rem;
  }

  .myP {
    text-align: justify;
    padding-left: 15%;
    padding-right: 15%;
    font-size: 20px;
  }

  @media all and (max-width:700px) {
    .myP {
      padding: 2%;
    }
  }

  .borderDemo {
    border-radius: 40px;
    background-color: #00E676;
  }

  .wording {
    font-size: 20px;
  }
</style>





</script>