<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

// Include config file
require_once "./DB/config.php";

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
              if($_SERVER["REQUEST_METHOD"] == "POST"){
               
                  // Validate new password
                  if(empty(trim($_POST["new_password"]))){
                      $new_password_err = "Please enter the new password.";     
                  } elseif(strlen(trim($_POST["new_password"])) < 6){
                      $new_password_err = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
                  } else{
                      $new_password = trim($_POST["new_password"]);
                  }
                  
                  // Validate confirm password
                  if(empty(trim($_POST["confirm_password"]))){
                      $confirm_password_err = "Please confirm the password.";
                  } else{
                      $confirm_password = trim($_POST["confirm_password"]);
                      if(empty($new_password_err) && ($new_password != $confirm_password)){
                          $confirm_password_err = "โปรดใส่รหัสผ่านให้ตรงกัน";
                      }
                  }
                      
                  // Check input errors before updating the database
                  if(empty($new_password_err) && empty($confirm_password_err)){
                      // Prepare an update statement
                      $sql = "UPDATE users SET password = ? WHERE id = ?";
                      
                      if($stmt = mysqli_prepare($link, $sql)){
                          // Bind variables to the prepared statement as parameters
                          mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
                          
                          // Set parameters
                          $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                          $param_id = $_SESSION["id"];
                          
                          // Attempt to execute the prepared statement
                          if(mysqli_stmt_execute($stmt)){
                              // Password updated successfully. Destroy the session, and redirect to login page
                              session_destroy();
                              header("location: http://localhost/project/Login_v16/index_login.php");
                              exit();
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




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>เปลี่ยนรหัสผ่าน</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body {
      font: 14px sans-serif;
    }

    .wrapper {
      width: 350px;
      padding: 20px;
    }
  </style>
</head>

<body>

 
  <div class="wrapper">
    <h2>เปลี่ยนรหัสผ่าน</h2>
    <p>กรุณากรอกแบบฟอร์มนี้เพื่อเปลี่ยนรหัสผ่านของคุณ</p>
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
        <input  type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>" required placeholder="รหัสผ่านใหม่">
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
</body>

</html>