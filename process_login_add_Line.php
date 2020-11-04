<?php
        $id = $_GET['id_line'];
        $username_line_page = $_GET['username'];
        ?> 
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myproject";

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "UPDATE users SET line='$id' WHERE username='$username_line_page'";

if ($conn->query($sql) === TRUE) {
  
} else {
  echo "Error updating record: " . $conn->error;
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ยืนยันตัวตน</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/gmail.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
</head>

<body>
    <?php

    if($id != null){
        echo '<div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
        
                <!-- Icon -->
                <div class="fadeIn first">
                    <br>
                    <br>
                    <img style="height:100px;width:100px;" src="./images/chat.png" alt="" />
                    <img style="height:100px;width:100px;" src="./images/line.png" alt="" />
                    </a>
                    <br>
                    <br>
                    <center><label class="fontf" style="font-size:25px;">เชื่อมต่อ LINE สำเร็จ</label><br>
                    <label for=""><b>แจ้งเตือนผ่านผู้ใช้ : </b>' . $username_line_page . '</label><br>
                    <a href="http://localhost/project/Login_v16/index_login.php">เข้าสู่ระบบได้ที่นี่.</a>
                        <br>
                        <label class="fontf" style="font-size:15px;color:gray;"></label>
                    </center>
                    <br>
                    <br>
                </div>'; 
    }else {
        echo '<div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
    
            <!-- Icon -->
            <div class="fadeIn first">
                <br>
                <br>
                <img style="height:100px;width:100px;" src="./images/chat.png" alt="" />
                <img style="height:100px;width:100px;" src="./images/line.png" alt="" />
                </a>
                <br>
                <br>
                <center><label class="fontf" style="font-size:25px;color:red">กรุณาดำเนินการใหม่ที่ Application LINE</label><br>
                
                <a href="http://localhost/project/Login_v16/index_login.php">เข้าสู่ระบบได้ที่นี่.</a>
                    <br>
                    <label class="fontf" style="font-size:15px;color:gray;"></label>
                </center>
                <br>
                <br>
            </div>'; 
    }

       
    
    mysqli_close($conn);
    ?>
    </div>
    </div>
    <!-- Remind Passowrd -->
    </div>
    </div>
</body>

</html>
<style>
    .fontf {
        font-family: 'Kanit', sans-serif;
    }

    html {
        background-color: #56baed;
    }

    body {
        font-family: "Poppins", sans-serif;
        height: 100vh;
    }

    a {
        color: #92badd;
        display: inline-block;
        text-decoration: none;
        font-weight: 400;
    }

    /* STRUCTURE */

    .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
        background-image: url("./images/bg33.jpg");
        background-size: cover;

    }

    #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
    }




    @-webkit-keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }

        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }

        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    /* Simple CSS3 Fade-in Animation */
    @-webkit-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .fadeIn {
        opacity: 0;
        -webkit-animation: fadeIn ease-in 1;
        -moz-animation: fadeIn ease-in 1;
        animation: fadeIn ease-in 1;

        -webkit-animation-fill-mode: forwards;
        -moz-animation-fill-mode: forwards;
        animation-fill-mode: forwards;

        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        animation-duration: 1s;
    }

    /* OTHERS */

    *:focus {
        outline: none;
    }

    #icon {
        width: 60%;
    }
</style>