<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/project/Login_v16/index_login.php");
    exit;
}
?>
<!--::: select_User ::: !>
<?php
 $id_session = $_SESSION['id'];
 
  $sql = "SELECT * FROM users where $id = $id_session ";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($result)) {
    $id[] = $row['id'];
    $username[] = $row['username'];
    $firstname[] = $row['firstname'];
    $lastname[] = $row['lastname'];
    $place_use[] = $row['place_use'];
  }
  
  ?>

<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/project/Login_v16/index_login.php");
    exit;
}

?>
<?php
require("./DB/config.php");
$username_ses = $_SESSION['username'];
?>
<?php

$sql = "SELECT * FROM the_location where username = '$username_ses' ";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $No[] = $row['No'];
    $name_location[] = $row['name_location'];
    $username_lo[] = $row['username'];
    $date[] = $row['date'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!----    Bootstrap   -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <!----  link   -->
  
</head>

<body>
    <nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="#">ระบบเฝ้าระวังภัยโบราณสถาน</a>
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">
                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo "<li><a href='#'>หน้าแรก</a></li>";
                    }
                    ?>

                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo "<li><a href='#'>ตั้งค่าอุปกรณ์</a></li>";
                    }
                    ?>

                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo " <li><a href='#'>รายงาน</a></li>";
                    }
                    ?>
                     <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo " <li><a href='profile.php'>ข้อมูลส่วนตัว</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo " <li><a href='logout.php'>ออกจากระบบ</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] != true) {
                        echo "<li><a href='register.php'>สมัครสมาชิก</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] != true) {
                        echo " <li><a href='login.php'>เข้าสู่ระบบ</a></li>";
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
    <?php 
        echo $_SESSION['username'];
        echo $id_session;
    ?>
    
    
    <?php include("show_sensor.php")?>
     
       
    </section>
    <div style="height: 1000px">

    </div>
    <!-- Jquery needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="scripts.js"></script>

</body>

</html>

<style>

body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-image: url('./images/bg11.png');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
        font-family: 'Mitr', sans-serif;
    }


    .col-sm-8 {
        background-color: dodgerblue;
       
    }

    .col-sm-4 {
        background-color: red;

    }
    #container {
  display: flex;
  justify-content: center;
  align-items: center;
  background: #37bc9b;
  height: 200px;
}
#container {
  display: flex;
  justify-content: center;
  background: #37bc9b;
  height: 200px;
}
.box {
  width: 50px;
  height: 50px;
  line-height: 50px;
  background: #434a54;
  color: #f5f7fa;
  border: 1px solid #ccd1d9;
  text-align: center;
}

.nav {
        width: 100%;
        height: 65px;
        position: fixed;
        line-height: 65px;
        text-align: center;
    }

    .nav div.logo {
        float: left;
        width: auto;
        height: auto;
        padding-left: 0rem;
        margin-left: -60pX;
    }

    .nav div.logo a {
        text-decoration: none;
        color: #fff;
        font-size: 2.5rem;
    }

    .nav div.logo a:hover {
        color: #00E676;
    }

    .nav div.main_list {
        height: 65px;
        float: right;
    }

    .nav div.main_list ul {
        width: 100%;
        height: 65px;
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav div.main_list ul li {
        width: auto;
        height: 65px;
        padding: 0;
        padding-right: 3rem;
    }

    .nav div.main_list ul li a {
        text-decoration: none;
        color: #fff;
        line-height: 65px;
        font-size: 2.4rem;
    }

    .nav div.main_list ul li a:hover {
        color: #00E676;
    }

    /* Home section */
    .home {
        width: 100%;
        height: 100vh;

        background-position: center top;
        background-size: cover;
        border: 0cm;

    }

    .navTrigger {
        display: none;
    }

    .nav {
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

        .nav div.logo {
            margin-left: 15px;
        }

        .nav div.main_list {
            width: 100%;
            height: 0;
            overflow: hidden;
        }

        .nav div.show_list {
            height: auto;
            display: none;
        }

        .nav div.main_list ul {
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

        .nav div.main_list ul li {
            width: 100%;
            text-align: right;
        }

        .nav div.main_list ul li a {
            text-align: center;
            width: 100%;
            font-size: 3rem;
            padding: 20px;
        }

        .nav div.media_button {
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