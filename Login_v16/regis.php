<?php
// Include config file
require_once "../DB/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	// Validate username
	
	$place_use = $_POST['place_use'];
    $firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
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
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password , firstname, lastname , place_use) VALUES (?, ? ,'$firstname' , '$lastname' , '$place_use')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: http://localhost/project/Login_v16/index_login.php");
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
	<title>สมัครสมาชิก</title>
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
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
                    สมัครสมาชิก
                    <p>Please fill this form to create an account.</p>
				</span>
                <form class="login100-form validate-form p-b-33 p-t-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                
                <div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="wrap-input100 validate-input"  >
                                        <input  class="input100" type="text" name="firstname"  class="form-control name"  placeholder="ชื่อจริง">
                                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="wrap-input100 validate-input" >
                                        <input  class="input100" type="text" name="lastname" id="last_name" class="form-control input-sm" placeholder="นามสกุล">
                                        <span class="focus-input100" ></span>
			    					</div>
			    				</div>
			    </div>
					<div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> " data-validate = "Enter username" >
						<input class="input100" type="email" name="username" placeholder="ชื่อผู้ใช้(อีเมล)" value="<?php echo $username; ?>">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>
                   

					<div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="รหัสผ่าน">
						<span class="focus-input100" data-placeholder="&#xe80f;"><?php echo $password_err; ?></span>
					</div>

					<div class="wrap-input100 validate-input <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label></label>
                <input type="password" name="confirm_password" class="input100" value="<?php echo $confirm_password; ?>" placeholder="ยืนยันรหัสผ่าน">
                <span class="focus-input100" data-placeholder="&#xe80f;"><?php echo $confirm_password_err; ?></span>
            </div>

					<div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> " data-validate = "Enter username" >
						<input class="input100" type="text" name="place_use" placeholder="รายละเอียดสถานที่" value="<?php echo $place_use; ?>">
						<span class="focus-input100"></span>
                    </div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" value="Login" type="submit">
							สมัครสมาชิก
						</button>
                    </div>
                    
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" value="" type="">
							ยกเลิก
						</button>
                    </div>
                </form>
                
			</div>
		</div>
    </div>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


    
	

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

.nav li {
  display: inline-block;
  font-size: 20px;
  padding: 20px;
}

</style>