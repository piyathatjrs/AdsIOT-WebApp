
<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: http://localhost/project/");
    exit;
}
 
// Include config file
require_once "../DB/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ? and verify=1";
        
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
              
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                           
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;  
                            
                            // if($username == "adsiot.system@gmail.com"){
                            //     $_SESSION["loggedin_admin"] = true;
                            //     header("location: http://localhost/project/admin.php");
                            // }else {
                            //       // Redirect user to welcome page
                            header("location: http://localhost/project/welcome.php");
                           // }
                            
                          
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "<center><span><i style='color:red'>รหัสผ่านที่คุณป้อนไม่ถูกต้อง</i></span></center>";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "<center><span><i style='color:red'>ไม่พบบัญชีผู้ใช้</i></span></center>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
	<title>เข้าสู่ระบบ</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body style="font-family: 'Mitr', sans-serif;">
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/background.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span style="font-family: 'Mitr', sans-serif;" class="login100-form-title p-b-41">
                    ลงชื่อเข้าใช้ 
                     <img src="../images/title.png" alt="" width="100%">
                </span>
            
				<form class="login100-form validate-form p-b-33 p-t-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >

					<div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> " data-validate = "Enter username" >
						<input style="font-family: 'Mitr', sans-serif;" autocomplete="off" class="input100" type="email" required name="username" placeholder="ชื่อผู้ใช้" value="<?php echo $username; ?>">
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        <span class="help-block"><?php echo $username_err; ?></span>
					</div>

					<div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate="Enter password">
						<input style="font-family: 'Mitr', sans-serif;" autocomplete="off" class="input100" type="password" name="password" placeholder="รหัสผ่าน">
						<span class="help-block"><?php echo $password_err; ?></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button style="font-family: 'Mitr', sans-serif;"  class="login100-form-btn" value="Login" type="submit">
							เข้าสู่ระบบ
						</button>
                    </div>
                    
                    <center><div style="padding:15px ;font-family: 'Mitr', sans-serif; ">
                        <p style="font-family: 'Mitr', sans-serif;">คุณยังไม่มีบัญชีใช่ไหม ? <a style="font-family: 'Mitr', sans-serif;" href="http://localhost/project/Login_v16/register/index.php">สมัครสมาชิก</a>.</p>
                        <p style="font-family: 'Mitr', sans-serif;">คุณลืมรหัสผ่าน ? <a style="font-family: 'Mitr', sans-serif;" href="http://localhost/project/Forgot_password.php">ลืมรหัสผ่าน</a>.</p>
                    </div></center>
					
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');
  

</style>
