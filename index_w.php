<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;500&display=swap" rel="stylesheet">
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
    <title>หน้าแรก</title>
</head>

<body>
    <nav class="nav">
        <div class="container">
            <div class="logo">
                <img src="./images/title.png" alt="" style="width:65%">
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">

                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo " <li><a href='index.php'>หน้าแรก</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo "  <li><a href='#'>รายงาน</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo "  <li><a href='profile.php'>ข้อมูลส่วนตัว</a></li>";
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
               <div class='con'>
                    <div style="" class=" text-center">
                <h1 style="color:#fff "><?php echo "สถานที่ทั้งหมดของฉัน" ?></h1>

                <center>
                    <div class="button_add" data-toggle="modal" data-target="#modalLoginAvatar"><span>เพิ่ม</span></div>
                </center>

            </div>
            <center>
                <div class="container">
                    <div class="row text">

                        <?php
                        if ($No) {
                            for ($i = 0; $i < count($No); $i++) {
                                echo '  <div class="col-sm-4">
                           <h3 class="name_location_h3" style="color:#fff "> <span class="text_location">' . $name_location[$i] . '</span></h3> <br>
              
               <button class="button"  onclick="show_sensor(' . $No[$i] . ')" id="No" value=' . $name_location[$i] . '><span>รายละเอียด</span></button>  
               <button class="but"  onclick="Del(' . $No[$i] . ')" id="No" value=' . $name_location[$i] . '><span>ลบ</span></button> 
               </div>
              ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </center>   
            </div>     
        

        
        <br><label for="">ยินดีต้อนรับ : <?php echo $username_ses; ?></label><br>


        </div>
        <div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <img src="./images/pins.png" height="250px" width="250px" alt="avatar" class="rounded-circle img-responsive">
                    </div>
                    <form action="process_the_location.php" method="POST">
                        <div class="modal-body text-center mb-1">
                            <h5 class="mt-1 mb-2">บริเวณที่ติดตั้ง</h5>
                            <input type="text" value="Add" name="type" hidden>
                            <div class="md-form ml-0 mr-0">
                                <input name='name_location' type="text" type="text" id="form29" class="form-control form-control-sm validate ml-0" placeholder="ชื่อ" required>
                            </div>
                            <div class="text-center mt-4">
                                <button name='username' class="btn btn-cyan mt-1" value=<?php echo $_SESSION['username']; ?>>สร้าง</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_Del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    </span>
                    <form class="login100-form validate-form p-b-33 p-t-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="text" id="Del_No">
                        <div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> " data-validate="Enter username">
                            <input class="input100" type="email" required name="username" placeholder="ชื่อผู้ใช้" value="<?php echo $username; ?>">
                            <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate="Enter password">
                            <input class="input100" type="password" name="password" placeholder="รหัสผ่าน">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="container-login100-form-btn m-t-32">
                            <button class="login100-form-btn" value="Login" type="submit">
                                เข้าสู่ระบบ
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        </section>

        <script>
            function Del(N) {
                var txt;
                var r = confirm("จะลบจริงๆใช่ไหม ?");
                if (r == true) {

                    window.location.assign("delete.php?No=" + N + "")
                    txt = "You pressed OK! " + N;
                } else {
                    txt = "You pressed Cancel! " + N;

                }
                console.log(txt);

            }

            function show_sensor(a) {
                window.location.assign("show_sensor.php?No_lo=" + a + "")
            }
        </script>
        <?php echo $password_err; ?></span>

   

    <!-- Jquery needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Function used to shrink nav bar removing paddings and adding black background -->
    <script>
        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
            }
        });

        $('.navTrigger').click(function () {
    $(this).toggleClass('active');
    console.log("Clicked menu");
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();

});



    </script>

    

</body>

</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');

    .con {
        padding-top: 150px;
    }

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


    .col-sm-4 {
        padding: 10px;
    }

    #del {
        border: 0;
        border-radius: 10px;
    }


    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto auto auto auto;
        grid-gap: 10px;
        background-color: #2196F3;
        padding: 10px;
    }

    .grid-container>div {
        background-color: rgba(255, 255, 255, 0.8);
        text-align: center;
        padding: 20px 0;
        font-size: 30px;
    }

    .item1 {
        grid-row: 1 / 4;
    }

    .button {
        opacity: 0.8;
        border-radius: 4px;
        background-color: #EAEDED;
        border: none;
        color: #000;
        text-align: center;
        font-size: 20px;
        padding: 15px;
        width: 200px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 2px;
    }

    .button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .button span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }



    .button:hover span {
        padding-right: 25px;

    }

    .button:hover span:after {
        opacity: 1;
        right: 0;
    }

    .but {
        border-radius: 4px;
        background-color: #EAEDED;
        border: none;
        color: #000;
        text-align: center;
        font-size: 15px;
        padding: 10px;
        width: 200px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 2px;
        opacity: 0.8;
    }

    .but span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .but span:after {
        content: '\26D4';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }



    .but:hover span {
        padding-right: 25px;
        color: red;
    }

    .but:hover span:after {
        opacity: 1;
        right: 0;
    }



    .name_location_h3 {

        padding: 10px;
        border-radius: 5px;
        text-shadow: 2px 2px 1px #000000;
        color: #2ECC71;
    }

    .button_add {
        opacity: 0.8;
        border-radius: 4px;
        background-color: green;
        border: none;
        color: #fff;
        text-align: center;
        font-size: 20px;
        padding: 15px;
        width: 150px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 2px;
    }

    .button_add span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .button_add span:after {
        content: '\2714';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;

    }



    .button_add:hover span {
        padding-right: 25px;


    }

    .button_add:hover span:after {
        opacity: 1;
        right: 0;
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
    .nav {
        width: 100%;
        height: 65px;
        position: fixed;
        line-height: 65px;
        text-align: center;
        z-index: 2048;
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