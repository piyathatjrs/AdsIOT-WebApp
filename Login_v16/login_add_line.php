<?php
// Include config file
require_once "../DB/config.php";
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$lines = $_GET["id_line"];
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ID_line = $_POST["code_line"];
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
        $sql = "SELECT id, username, password FROM users WHERE username = ? and verify=1";


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
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["log_line"] = true;
                            $_SESSION["username_line"] =   $username;

                            if ($_SESSION["log_line"] = true) {

                                $sql = "SELECT * FROM users where username = '$_SESSION[username_line] ' ";
                                $result = $link->query($sql);
                                if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    if($row['line'] != null){
                                            $link_back_line = "process_login_add.php?username=$username&id_line=$ID_line";
                                        require("verlify_no_line.php");
                                     
                                    }else {
                                         header('Location: http://localhost/project/process_login_add_line.php?username='.$username.'&id_line='.$ID_line.'');
                                    }
                                }
                                }
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
    <title>เชื่อต่อ LINE (สำหรับแจ้งเตือน)</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
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

    <div id="body_login" class="limiter">
        <div class="container-login100" style="background-image: url('images/background.jpg');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span style="font-family: 'Mitr', sans-serif;" class="login100-form-title p-b-41">
                    กรอกชื่อผู้ใช้และรหัสผ่าน<br>เพื่อเชื่อมต่อกับ LINE <br>
                    <img src="../images/chat.png" alt="" width="50px" height="50px">
                    <img src="../images/line.png" alt="" width="50px" height="50px">
                   
                    <?php 
                        if($lines != null){
                            echo "<h4 style='color:green'>เข้าสู่ระบบได้</h4>";
                        }else {
                            echo "<h4 style='color:red'>กรุณากดรับรหัสใหม่ หรือ กดลิงค์เดิมจากLINE อีกครั้ง</h4>";
                        }
                    
                    ?>
                </span>
                <form id="login" class="login100-form validate-form p-b-33 p-t-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> " data-validate="Enter username">
                        <input style="font-family: 'Mitr', sans-serif;" autocomplete="off" class="input100" type="email" required name="username" placeholder="ชื่อผู้ใช้" value="<?php echo $username; ?>">
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate="Enter password">
                        <input style="font-family: 'Mitr', sans-serif;" autocomplete="off" class="input100" type="password" name="password" placeholder="รหัสผ่าน">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                   <input  name="code_line" value="<?php echo   $lines?>" required hidden>
                    <div class="container-login100-form-btn m-t-32">
                        <button style="font-family: 'Mitr', sans-serif;" class="login100-form-btn" value="Login" type="submit">
                            ยืนยัน
                        </button>
                    </div>
                    <center>
                        <div style="padding:15px ;font-family: 'Mitr', sans-serif; ">
                        </div>
                    </center>

                </form>
            </div>
        </div>
    </div>

    <script>
        function coppy() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("คัดลอกเรียบร้อย : " + copyText.value);
        }
        function goBack() {
  window.history.back();
}
       
    </script>


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