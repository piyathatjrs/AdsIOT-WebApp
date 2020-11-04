<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'myproject');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<?php

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	// Validate username
	
	$place_use = $_POST['place_use'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $line_id = $_POST['line_id'];
    $numrand = (mt_rand());
	
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ? ";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "<b><div style='color:red'>ต้องมีอย่างน้อย 8 ตัว</div></b>";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "<b><div style='color:red'>กรุณายืนยันรหัสผ่าน</div></b>";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "<b><div style='color:red'>กรุณาใส่รหัสผ่านให้ตรงกัน  </div></b>";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password , firstname, lastname , place_use , line_id ,verify) 
        VALUES (?, ? ,'$firstname' , '$lastname' , '$place_use' , '$line_id' ,$numrand )";

       

         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page

             

                $email = $_POST['username'];
                $strTo = $email;
                $strHeader = "Content-type: text/html; charset=UTF-8\n"; 
                $strHeader .= "From: adsiot.system@gmail.com";
                $strMessage = "ยินดีต้อนรับสมาชิก E-mail : ".$email."<br>";
                $strMessage .= "กรุณาทำยืนยันอีเมลล์ เพื่อให้การสมัครสมาชิกของท่านเสร็จสมบูรณ์ โดยกดที่ลิ้งข้างล่างนี้";
                $strMessage .= "<a class='btn'  style='color:red;font-size:20px' href=http://localhost/project/verify_mail.php?numrand=$numrand&username_check=".$_POST['username']."&username=".$_POST['username'].">"."<br>"."<br>"; 
                $strMessage .= "กดเพื่อยืนยันอีเมลล์"."</a>"."<br>"."<br>";
                $strSubject = "An Adaptive Disaster Surveillance System of Archaeological Site with Internet of Things (Verify Email)";
                
                $flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);

   

                header("location: http://localhost/project/verify_mail.php?username_check=".$_POST['username']."");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สมัครสมาชิก</title>
   <link rel="shortcut icon" type="image/x-icon" href="user.png" />
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- -----------navbar -->
</head>
<body>

    <div class="main">

        <section class="fontst signup ">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <center>
            <img src="./images/title.png"></center>
                <div class="signup-content">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="signup-form" class="signup-form"    >
                        <h2 class="fontst form-title">สร้างบัญชี</h2>
                        <div class="fontst form-group">
                            <input autocomplete="off"  class="form-input" type="text" name="firstname" id="" placeholder="ชื่อจริง"/ required>
                        </div>
                        <div class="fontst form-group">
                            <input autocomplete="off"  class="form-input"type="text" name="lastname" id="last_name" placeholder="นามสกุล"/ required>
                        </div>
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" data-validate = "Enter username" required>
                            <input autocomplete="off" type="email" class="form-input" name="username" id="" placeholder="อีเมล"/>
                            <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        </div>
                        <div class="form-group  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?> "  data-validate="Enter password" required>
                            <input autocomplete="off" type="password" class="form-input" name="password" id="password" placeholder="รหัสผ่าน"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                            <span class="focus-input100" data-placeholder="&#xe80f;"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <input autocomplete="off" type="password" class="form-input" name="confirm_password" id="re_password" value="<?php echo $confirm_password; ?>"  placeholder="ยืนยันรหัสผ่าน"/ required>
                            <span class="focus-input100" data-placeholder="&#xe80f;"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input autocomplete="off" type="text" class="form-input" name="place_use" id="" placeholder="สังกัด/สถานที่ติดตั้งระบบ"/ value="<?php echo $place_use; ?>" required>
                        </div>
                        <div class="form-group">
                            <input autocomplete="off" type="text" class="form-input" name="line_id" id="" placeholder="อธิบายเกี่ยวกับสถานที่" value="<?php echo $line_id; ?>"  required>
                        </div>
                        <div class="form-group cbox" >
                          
                            <input autocomplete="off" onclick="K()" type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                            <label for="agree-term" class="label-agree-term"><span><span></span></span>ยอมรับเงื่อนไขและข้อกำหนด  <a href="#" class="term-service">อ่านเงื่อนไขและข้อกำหนด</a></label>
                        </div>
                        <div class="fontst form-group">
                            <input autocomplete="off" type="submit" name="submit" id="btn_save" class="form-submit" value="สร้างบัญชี"/ hidden>
                        </div>
                    </form>
                    <p class="loginhere">
                        คุณมีบัญชีอยู่แล้วใช่หรือไม่ ? <a href="http://localhost/project/Login_v16/index_login.php" class="loginhere-link">เข้าสู่ระบบ</a>
                    </p>
                </div>
            </div>
           
        </section>

    </div>
    <script>
    
      function K(){
        var str = document.getElementById("agree-term").checked;
        if(str==false){
            $("#btn_save").hide();
            console.log(str);

        }else {
           
            $("#btn_save").show(); 
             console.log(str);
        }
           
      }
        
    </script>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');

@import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');

.fontst{
    font-family: 'Mitr', sans-serif;
}
#btn_save:hover{
    cursor: pointer;
}
</style>
</html>