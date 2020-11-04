<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;500&display=swap" rel="stylesheet">

<?php require("process_mqtt_send.php") ?>
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

$sql = "SELECT * FROM users where username = '$username_ses' ";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $id[] = $row['id'];
    $firstname[] = $row['firstname'];
    $lastname[] = $row['lastname'];
    $place_use[] = $row['place_use'];
    $line[] = $row['line'];
}

$sql_map = "SELECT * FROM map where username = '$username_ses' and No_location =999999";
$result_map = mysqli_query($link, $sql_map);
while ($row_map = mysqli_fetch_array($result_map)) {
    $No_map[] = $row_map['No'];
    $let[] = $row_map['let'];
    $lng[] = $row_map['lng'];
}

if($_POST['new_name_location']){
    $new_name = $_POST['new_name_location'];
    $number = $_POST["number"];
  

    $sql_up = "UPDATE the_location SET name_location='$new_name' where No = $number";
    if ($link->query($sql_up) === TRUE) {
      echo "Ok";
      echo "<script>
      window.location = 'http://localhost/project/welcome.php';
    </script>";
    } else {
      echo "Error updating record: " . $link->error;
    }   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="./images/home-run.png" />
    <title>หน้าแรก(<?php echo  $place_use[0]; ?>)</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<!-- <script>
    function initMap() {


        var mapOptions = new google.maps.Map(document.getElementById('map'), {
            zoom: 18,
            center: {
                lat: 13.847860,
                lng: 100.604274
            },
        });
        var geocoder = new google.maps.Geocoder();
        document.getElementById('submit').addEventListener('click', function() {
            geocodeAddress(geocoder, mapOptions);
        });



        var infoWindow = new google.maps.InfoWindow({
            content: 'Click the map to get Lat/Lng!',
            position: mapOptions
        });
        infoWindow.open(mapOptions);

        // Configure the click listener.
        mapOptions.addListener('click', function(mapsMouseEvent) {

            // Close the current InfoWindow.
            infoWindow.close();
            console.log(mapsMouseEvent);
            console.log(mapsMouseEvent.latLng.lat(0));
            console.log(mapsMouseEvent.latLng.lng(0));
            document.getElementById('A').value = mapsMouseEvent.latLng.lat(0);
            document.getElementById('B').value = mapsMouseEvent.latLng.lng(0);
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng
            });
            infoWindow.setContent(mapsMouseEvent.latLng.toString());
            infoWindow.open(mapOptions);
        });

    }

    function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            console.log(results[0].geometry.location.lng());
            console.log(results[0].geometry.location.lat());
            const lett = results[0].geometry.location.lng();
            console.log("let" + lett);


            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                // var marker = new google.maps.Marker({
                //     map: resultsMap,
                //     position: results[0].geometry.location
                // });
            } else {
                alert('ไม่พบที่อยู่ ' + status);
            }
        });
    }
    var locations = [
        ['<?php echo $name_loca_map[0]; ?>', <?php echo $let[0]; ?>, <?php echo $lng[0]; ?>],
    ];

    function initMap_show() {
        var mapOptions = {
            center: {
                lat: <?php echo $let[0]; ?>,
                lng: <?php echo $lng[0]; ?>
            },
            zoom: 18,
        }
        var maps = new google.maps.Map(document.getElementById("maps"), mapOptions);

        var marker, i, info;

        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: maps,
                title: locations[i][0]
            });

            info = new google.maps.InfoWindow();

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    info.setContent(locations[i][0]);
                    info.open(maps, marker);
                }
            })(marker, i));
        }
    }
</script> -->

<body>
    <nav class="nav">
        <div class="container-fluid">
            <div class="logo">
                <img src="./images/title.png" alt="" style="width:65%">
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">

                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo " <li><a href='welcome.php'>หน้าแรก</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo "  <li><a href='http://localhost/project/report.php'>รายงาน</a></li>";
                    }
                    ?>
                    <?php
                    if ($_SESSION["loggedin"] == true) {
                        echo "  <li><a href='profile.php'>ข้อมูลส่วนตัว</a></li>";
                    }
                    ?>
                      <?php
                    if ($_SESSION["loggedin"] == true) {

                        echo '   <li><a style="cursor:pointer"><div data-toggle="modal" data-target="#modalLoginAvatar_line"><span>เชื่อมต่อLINE</span></div></a></li>';
                        
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

            <div class="jumbotron text-center" style="background-color:#181818 ;padding-top:50px 0 50px 0">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 style="color:#fff ; font-size:35px"><?php echo  $place_use[0]; ?></h1>
                            <label for="" class="welcome">ยินดีต้อนรับ : <b><span> <?php echo $firstname[0] . " " . $lastname[0]; ?></span></b></label>
                            <br><i><label style="font-size:15px;color:cadetblue" for=""><?php echo $username_ses; ?></label></i>
                            <center>
                                <div class="button_add" data-toggle="modal" data-target="#modalLoginAvatar"><span>เพิ่ม</span></div>
                            </center>
                          
                        </div>
                    </div>
                </div>
            </div>
            <center><br><br>
                <div class="container">
                    <div class="row text">

                        <?php
                        if ($No) {
                            for ($i = 0; $i < count($No); $i++) {
                                echo '  <div id="card_location" class="col-sm-3" style="background-color:#000; opacity:80%;padding-top:25px;
                                padding-bottom:25px;border-radius: 20px; border:5px solid ' . $location_status . '">
                           <h3 class="name_location_h3" style="color:#fff "> <span class="text_location"> 
                           <form action="welcome.php" method="post">
                           
                           <input style="text-align:center;background-color:#000;color:#fff;border:0" type="text" name="new_name_location" id="numlo' . $No[$i] . '" value="' . $name_location[$i] . '" disabled> 
                           <select name="number" id="" hidden>

                           <option value="' . $No[$i] . '"></option>
                           </select>
                           <img onclick="edit(' . $No[$i] . ')"  class="edit_location" src="./images/edit.png" alt="" height="20px" width="20px">
                       
                            
                           </span></h3></form> <br>
              
               <button class="button"  onclick="show_sensor(' . $No[$i] . ')" id="No" value=' . $name_location[$i] . '><span>รายละเอียด</span></button>
                
               <button href="#myModal" onclick="Del(' . $No[$i] . ')" class="trigger-btn but" data-toggle="modal"><span>ลบ</span></button>
               </div>
              ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </center>
        </div>
        </div>


        <div style="padding-top:80px; " class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

                <div class="modal-content" style="border-radius: 10px;">
                    <div class="modal-header">
                        <center><img src="./images/pins.png" height="250px" width="250px" alt="avatar" class="rounded-circle img-responsive"></center>
                    </div>
                    <form action="process_the_location.php" method="POST">
                        <div class="modal-body text-center mb-1">
                            <h1 class="mt-1 mb-2">บริเวณที่ติดตั้ง</h1>
                            <input type="text" value="Add" name="type" hidden>
                            <div class="md-form ml-0 mr-0">
                                <input autocomplete="off" style="height:30px; font-size:20px ;" name='name_location' type="text" type="text" id="form29" class="form-control form-control-sm validate ml-0" placeholder="ชื่อ" required>
                            </div>
                            <div class="text-center mt-4">
                                <button name='username' class="btn btn-cyan mt-1" value=<?php echo $_SESSION['username']; ?>>
                                    <h2>สร้าง</h2>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="padding-top:80px; " class="modal fade" id="modalLoginAvatar_line" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

                <div class="modal-content" style="border-radius: 10px;">
                    <div style="padding-left:17%" class="modal-header">
                        <center><img src="./images/Qrcode_Linebot.png" height="220px" width="100%" alt="avatar" class="img-responsive">
                        <p>@137nmroa</p>
                    </center>
                    </div>
                    <form action="add_line.php" method="POST">
                        <div class="modal-body text-center mb-1">
                            <h1 class="mt-1 mb-2">LINE</h1>
                            <?php 
                                    if($line[0] == null){
                                        echo "<h3 style='color:red'>ท่านยังไม่ได้เชื่อมต่อ</h3>";
                                    }else {
                                        echo "<h5 style='color:green'>เชื่อมต่อแล้ว</h5>";
                                    }
                            ?>

                            <input type="text" value="Add" name="type" hidden>
                            <div class="md-form ml-0 mr-0">
                                <!-- <input autocomplete="off" style="height:30px; font-size:20px ;" name='uid' type="text" type="text" id="form29" class="form-control form-control-sm validate ml-0" placeholder="รหัส" minlength="32" maxlength="32" required> -->
                            </div>
                            <div class="text-center mt-4">
                                <!-- <button name='username' class="btn btn-cyan mt-1" value=<?php echo $_SESSION['username']; ?>>
                                    <h2>เพิ่ม</h2>
                            
                                </button> -->
                                <h5 > หมายเหตุ : หากต้องการเปลี่ยนไลน์ หรือ เริ่มการใช้งานในการแจ้งเตือน "ดำเนินการผ่าน Application LINE " <br></h5>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div style="padding-top:100px" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div style="padding:15px" class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <input style="width:100%" id="address" type="textbox" placeholder="ใส่สถานที่ของคุณ">
                            </div>
                            <div class="col-sm-2">
                                <input id="submit" type="button" value="ค้นหา">
                            </div>
                        </div>
                        <div style="padding:10px" class='row'>
                            <div id="map"></div>
                        </div>
                        <div style="padding:10px" class='row'>
                            <div class="col-sm-2">
                                <label for=""><b>ละติจูด</b> </label><input style="border:0" for="A" id="A" value="" disabled>
                            </div>
                            <div class="col-sm-2">
                                <label for=""><b>ลองจิจูด</b> </label><input style="border:0" for="B" id="B" value="" disabled>
                            </div>
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-2">
                                <input style="float:right" id='btn_save' type="button" value="บันทึก">
                            </div>
                        </div>
                    </div>




                    <script>
                        //All_Button

                        $("#btn_save").hide();
                        $('#submit').click(function() {

                            $("#btn_save").show();
                        });
                        $("#btn_save").click(function() {
                            var let_value = document.getElementById("A").value;
                            var lng_value = document.getElementById("B").value;
                            console.log(let_value)
                            console.log(lng_value)
                            window.location.assign('http://localhost/project/process_update_map.php?let_value=' + let_value + '&acc="add"&lng_value=' + lng_value + '&No_location=' + 999999 + '');
                        });

                        $("#delete_map").click(function() {
                            window.location.assign('http://localhost/project/process_update_map.php?acc="set_map"&No_location_del=' + 999999 + '');

                        });

                        function edit(numlo) {
                            var location = "numlo" + numlo;
                            document.getElementById(location).disabled = false;
                            document.getElementById(location).style.backgroundColor = "#fff";
                            document.getElementById(location).style.color = "#000";
                        }
                    </script>
                </div>
            </div>


    </section>
    <div style="height: 200px">
    </div>

    <script>
        function Del(N) {

            $("#conf").click(function() {
                window.location.assign("delete.php?No=" + N + "");
            });


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

        $('.navTrigger').click(function() {
            $(this).toggleClass('active');
            console.log("Clicked menu");
            $("#mainListDiv").toggleClass("show_list");
            $("#mainListDiv").fadeIn();

        });
    </script>
    </div>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="material-icons">&#xE5CD;</i>
                    </div>
                    <h4 class="modal-title w-100">คุณแน่ใจว่าจะลบ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>เมื่อทำการลบสถานที่ อุปกรณ์ที่ทำการติดตั้งจะถูกปิดโดยอัตโนมัติ</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" id='conf' class="btn btn-danger ">ลบ</button>
                </div>
            </div>
        </div>
        <div>
</body>

</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');


    .edit_location:hover {
        cursor: pointer;
    }

    #maps {
        height: 100%;
        width: 100%;
        border-radius: 10px;
    }

    #maps {
        -webkit-box-shadow: 5px 5px 15px 5px #949494;
        box-shadow: 3px 3px 15px 3px #949494;
    }

    .welcome {
        font-size: 20px;
        color: red;

    }

    .welcome span {
        color: #fff;
    }

    .con {
        padding-top: 90px;
    }

    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #404040;
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

    #map {
        height: 500px;
        width: 600px;
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

        text-shadow: 0px 0px 4px rgba(0, 0, 0, 0.77);
        color: #FFFFFF;


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
        height: 90px;
        background-color: #000;
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


    .modal-confirm {
        color: #636363;
        width: 400px;
        margin-top: 200px;
    }

    .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
        text-align: center;
        font-size: 14px;
    }

    .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-confirm h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -10px;
    }

    .modal-confirm .close {
        position: absolute;
        top: -5px;
        right: -2px;
    }

    .modal-confirm .modal-body {
        color: #999;
    }

    .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
        padding: 10px 15px 25px;
    }

    .modal-confirm .modal-footer a {
        color: #999;
    }

    .modal-confirm .icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        z-index: 9;
        text-align: center;
        border: 3px solid #f15e5e;
    }

    .modal-confirm .icon-box i {
        color: #f15e5e;
        font-size: 46px;
        display: inline-block;
        margin-top: 13px;
    }

    .modal-confirm .btn,
    .modal-confirm .btn:active {
        color: #fff;
        border-radius: 4px;
        background: #60c7c1;
        text-decoration: none;
        transition: all 0.4s;
        line-height: normal;
        min-width: 120px;
        border: none;
        min-height: 40px;
        border-radius: 3px;
        margin: 0 5px;
    }

    .modal-confirm .btn-secondary {
        background: #c1c1c1;
    }

    .modal-confirm .btn-secondary:hover,
    .modal-confirm .btn-secondary:focus {
        background: #a8a8a8;
    }

    .modal-confirm .btn-danger {
        background: #f15e5e;
    }

    .modal-confirm .btn-danger:hover,
    .modal-confirm .btn-danger:focus {
        background: #ee3535;
    }

    .trigger-btn {
        display: inline-block;
        margin: 0px auto;
    }
</style>