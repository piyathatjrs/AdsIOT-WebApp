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


if ($_GET['username']) {
  $username_ver = $_GET['username'];
  $numrand = $_GET['numrand'];
  $sql = "UPDATE users SET verify=true WHERE username='$username_ver' and verify=$numrand";

  if (mysqli_query($conn, $sql)) {

  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
}


if ($_GET['username_check']) {
  $username_check = $_GET['username_check'];

  $sql_ver = "SELECT * FROM users where username = '$username_check' ";
  $result = mysqli_query($conn, $sql_ver);
  while ($row = mysqli_fetch_array($result)) {
    $id[] = $row['id'];
    $verify[] = $row['verify'];
  }
}

$username = $_GET['username'];
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
          if ($verify[0] !=1) {
            echo '<div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
        
                <!-- Icon -->
                <div class="fadeIn first">
                    <br>
                    <br>
                    <img style="height:100px;width:100px;" src="./images/gmail.png" alt="" /></a>
                    <br>
                    <br>
                    <center><label class="fontf" style="font-size:25px;">กรุณายืนยันตัวตนก่อนเริ่มใช้งาน</label><br>
                    <label for=""><b>ทำการส่งไปที่อีเมล : </b>'.$username_check.'</label><br>
                    
                        <br>
                        <label class="fontf" style="font-size:15px;color:gray;"></label>
                    </center>
                    <br>
                    <br>
                </div>';
          } else if($verify[0]==1) {
             
            echo '<div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
        
                <!-- Icon -->
                <div class="fadeIn first">
                    <br>
                    <br>
                    <img style="height:100px;width:100px;" src="./images/success.png" alt="" /></a>
                    <br>
                    <br>
                    <center><label class="fontf" style="font-size:25px;">ยืนยันตัวตนสำเร็จ</label><br>
                    <label for=""><b>ยินดีต้อนรับ : </b>'.$username_check.'</label><br>
                    <a href="http://localhost/project/Login_v16/index_login.php">เข้าสู่ระบบเพื่อเริ่มต้นการใช้งานได้ที่นี่.</a>
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