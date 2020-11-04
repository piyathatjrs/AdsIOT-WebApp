

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>ลืมรหัสผ่าน</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;500&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Mitr', sans-serif;">



<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bootstrap Theme Company Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
  .jumbotron {
    background-color: #f4511e;
    color: #fff;
  }
  </style>
</head>
<body>
    


<div class="jumbotron text-center">
  <h1>ลืมรหัสผ่านใช่ไหม ?</h1> 
  <p>โปรดใส่อีเมลของคุณเพื่อรับรหัสผ่านใหม่</p> 
  <form class="form-inline" action="http://localhost/project/send_mail.php" method="POST" >
    <div class="input-group">
      <input  type="email" name="email"  class="form-control" size="50" placeholder="ใส่อีเมลของคุณ" required>
      <div class="input-group-btn">
        <button type="submit" class="btn btn-danger">ยืนยัน</button>
      </div>
    </div>
  </form>
  <?php
session_start();

if ($_SESSION["loggedin"] == true) {
    echo "<a href='index.php'>หน้าแรก</a>";
}
?>
<?php
if ($_SESSION["loggedin"] == true) {
    echo " <a href='#'>รายงาน</a>";
}
?>
<?php
if ($_SESSION["loggedin"] == true) {
    echo " <a href='profile.php'>ข้อมูลส่วนตัว</a>";
}
?>
<?php
if ($_SESSION["loggedin"] == true) {
    echo " <a href='logout.php'>ออกจากระบบ</a>";
}
?>
<?php
if ($_SESSION["loggedin"] != true) {
    echo "<a href='http://localhost/project/Login_v16/register/index.php'>สมัครสมาชิก</a>";
}
?>
<?php
if ($_SESSION["loggedin"] != true) {
    echo " <a href='http://localhost/project/Login_v16/index_login.php'>เข้าสู่ระบบ</a>";
}
?>
</div>

</body>
</html>

</body>
</html>
<style>
 @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');
  a{
    color:blanchedalmond;
    font-size: 20px;
  }
</style>