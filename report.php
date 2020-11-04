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
$username_ses = $_SESSION['username'];
?>
<?php
require("./DB/config.php");

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
    $line[] = $row['line'];
    $place_use[] = $row['place_use'];
}

$sql_sen = "SELECT * FROM sensor where User_use = '$username_ses'";
$result_sen = mysqli_query($link, $sql_sen);
while ($row_sen = mysqli_fetch_array($result_sen)) {
    $No_sensor[] = $row_sen['No'];
    $name_sen[] = $row_sen['Name_sensor'];
    $code[] = $row_sen['Code'];
    $detail[] =  $row_sen['Detail'];
    $img[] = $row_sen['img'];
    $topic[] = $row_sen['topic'];
    $on_off[] = $row_sen['On_off'];
    $status[] = $row_sen['status'];
    $type[] = $row_sen['type'];
    $save_time[] = $row_sen['save_time'];
    $set_val1[] = $row_sen['set_val1'];
    $set_val2[] = $row_sen['set_val2'];
    $set_val3[] = $row_sen['set_val3'];
}
$sql_select = "SELECT * from sensor s join report_all r on s.Code = r.code join the_location l on l.No = r.location where r.username = '$username_ses' and s.No_location = l.No  GROUP by r.code ";
$result_select = mysqli_query($link, $sql_select);
while ($row_select = mysqli_fetch_array($result_select)) {
    $No_select[] = $row_select['No'];
    $name_lo[] = $row_select['name_location'];
    $name_sensor_select[] = $row_select['Name_sensor'];
    $code_select[] = $row_select["code"];
    $no[] = $row_select['No_location'];
}



if ($_POST["code"]) {
    $type = " - ";
    if ($_POST["code"] === 'S101') {
        $type = "อุณหภูมิ";
    } else if ($_POST["code"] === 'S102') {
        $type = "ความชื้นในดิน";
    } else if ($_POST["code"] === 'S103') {
        $type = "ระดับน้ำ";
    } else if ($_POST["code"] === 'S104') {
        $type = "ปริมาณน้ำฝน";
    } else if ($_POST["code"] === 'S105') {
        $type = "ความโน้มเอียง";
    }

    $start_date = $_POST['date_start'];
    $end_date = $_POST['date_end'];

    $datedate = date("Y-m-d", strtotime("+1 day", strtotime($end_date)));
    // echo $start_date." - " . $end_date;
    $code_input = $_POST['code'];
    $con = mysqli_connect("localhost", "root", "", "myproject") or die("Error: " . mysqli_error($con));
    mysqli_query($con, "SET NAMES 'utf8' ");
    $query = "SELECT * FROM report_all where code ='$code_input'and  username = '$username_ses' and date BETWEEN date('$start_date') AND date('$datedate')";
    $result = mysqli_query($con, $query);
    $resultchart = mysqli_query($con, $query);
    //for chart
    $datesave = array();
    $totol = array();
    $green = 'green';
    $red = 'red';
    while ($rs = mysqli_fetch_array($resultchart)) {

        $datesave[] = "\"" . $rs['date'] . "\"";
        $totol[] = "\"" . $rs['value1'] . "\"";
        $color[] = "\"" . $rs['color'] . "\"";
        // if ($rs['status'] == 1) {
        //     $status[] = "\"" . $green . "\"";
        // }
        // if ($rs['status'] == 2) {
        //     $status[] = "\"" . $red . "\"";
        // }
        $status[] = "\"" . $rs['status'] . "\"";
    }

    if (count($totol) == 0) {
        $status_G = "ไม่พบข้อมูลที่เลือก";
    } else if (count($totol) > 0) {
        $datesave = implode(",", $datesave);
        $totol = implode(",", $totol);
        $color = implode(",", $color);
        $status = implode(",", $status);
    }

?>
<?php
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานแบบกราฟ</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/report.png" />
    <script src="script.js"></script>
    <script src="https://dribbble.com/shots/2536070-Jelly-Buttons-CSS"></script>
    <script src="html2pdf.bundle.min.js"></script>
</head>

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
        </div>
    </nav>
    <section style="padding-top:11.5%;; height:auto" class="home">

    <?php echo "<center><h1 style=' color:#DC7633'>สถานที่ : ".$place_use[0]."</h1></center>"; ?>
  
        <center>
            <div style="color:#fff">
                <h2>การเรียกดูข้อมูลย้อนหลังชนิดกราฟ (เลือกตาม - สถานที่/เซ็นเซอร์/วันที่)</h2>  
                <div class="container">
  <div class="row" style="padding:5px 1px 3px 1px;width:20%;background-color:grey;border-radius:10px">
    <div class="col-sm">
    <div><div id="circle_green"></div><label>ปกติ</label></div>
    </div>
    <div class="col-sm">
    <div><div id="circle_red"></div><label>ผิดปกติ</label></div>
    </div>
    
  </div>
</div>
            </div>
           
                <?php 
                       echo "<h3><b style='color:red'>".$status_G."</b></h3><br>";
            
                ?>
        </center>

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
                                <h5> หมายเหตุ : หากต้องการเปลี่ยนไลน์ หรือ เริ่มการใช้งานในการแจ้งเตือน "ดำเนินการผ่าน Application LINE " <br><span style="color:red">โดยพิมพ์ข้อความว่า "...."</span></h5>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="container">


            <form class="locate" action="" method="post">

                <div class="row">

                    <div class="col-md-4">
                        <select style="font-size:220% ;background-color:#566573 " name="code" id="location" class="dropdown btn btn-secondary btn-lg dropdown-toggle" required>
                            <option value="">กรุณาเลือกสถานที่/ชนิดเซ็นเซอร์ </option>
                            <?php
                            if ($No_select != null) {
                                for ($i = 0; $i < count($No_select); $i++) {
                                    echo '<option value="' . $code_select[$i] . '">' . $name_lo[$i] . " - " . $name_sensor_select[$i] . '</option>';
                                }
                            }
                            ?>
                        </select>
                     
                           <div class="row" style="padding:3% 0 1% 50%" ><h4 style="color:#ecf0f1"><b>เลือกวันที่</b></h4></div>
                      
                        <div style="padding:10px" class="row">

                       
                            <div class="col-md-6">
                                <input type="date" id="date_start" name="date_start" max="<?php $date_validation = date("Y-m-d");
                                                                                            echo $date_validation; ?>" required>
                            </div>

                            <div class="col-md-6">
                                <input type="date" id="date_end" name="date_end" max="<?php $date_validation = date("Y-m-d");
                                                                                        echo $date_validation; ?>" required>
                            </div>
                            <button type="submit" id="sub_s" class="btn btn-lg btn-success" style="margin-top:5%;background-color: #45D33A; width:100% ;height:100%">ค้นหา</button>
                        
                            <button onclick="table_report()" class=" btn-lg btn-success" style="margin-top:10px;border:0 ; background-color: #5DADE2; width:100%;height:100%">ดูข้อมูลทั้งหมดแบบตาราง</button>

                        </div>
                    </div>
            </form>
            <div class="col-md-8">
                <div id="invoice">
                    <canvas id="myChart"></canvas>
            </div>
            <div class="c">
                    <button class="btn_download" onclick="generatePDF()">ดาวน์โหลด<img src="./images/download.png" alt="" height="5%" width="5%"> </button>
                </div>
        </div>

        </div>


        <!-- <div class="container-fluid conten">
            <div class="row">
                <div class="col-sm-5 col1">
                    <div class="row">
                        <form class="locate" action="" method="post">
                            <div class="col-sm">
                                <h3> สถานที่เรียกดู:</h3>

                                <select name="code" id="location" class="dropdown btn btn-secondary btn-lg dropdown-toggle" required>
                                    <option value="">กรุณาเลือกสถานที่/ชนิดเซ็นเซอร์ </option>
                                    <?php
                                    if ($No_select != null) {
                                        for ($i = 0; $i < count($No_select); $i++) {
                                            echo '<option value="' . $code_select[$i] . '">' . $name_lo[$i] . " - " . $name_sensor_select[$i] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm">
                            </div>
                    </div>
                    <div style="padding-top:20px" class="row">
                        <h3>เดือน/วัน/ปี</h3>
                        <div class="col-sm">
                            <input type="date" id="date_start" name="date_start" max="<?php $date_validation = date("Y-m-d");
                                                                                        echo $date_validation; ?>" required>
                        </div>
                        <div class="col-sm">
                            <input type="date" id="date_end" name="date_end" max="<?php $date_validation = date("Y-m-d");
                                                                                    echo $date_validation; ?>" required>
                        </div>
                    </div>
                    <div style="padding-top:5%;" class="row">


                        <div class="container-fluid">
                            <div style="text-align:center" class="row">
                                <div class="col-sm-5">
                                    <button type="submit" id="sub_s" class="btn btn-lg btn-success" style="background-color: #45D33A; width:100% ;height:100%">ค้นหา</button>

                                </div>
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-5">
                                    <button onclick="table_report()" class="btn btn-lg btn-success" style="background-color: #5DADE2; width:100%;height:100%">ดูข้อมูลทั้งหมดแบบตาราง</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>


                <div style="width:20px ; height:20px;" class="col-sm col2">
                    <a style="color:#fff;font-size:200%;">การเรียกดูข้อมูลย้อนหลังชนิดกราฟ (เลือกตาม - สถานที่/เซ็นเซอร์/วันที่)</a>
                    <center>
                        <div id="invoice">
                            <canvas id="myChart"></canvas>
                        </div>
                        <button class="btn_download" onclick="generatePDF()">ดาวน์โหลด<img src="./images/download.png" alt="" height="30px" width="30px"> </button>
                </div>
                </center>
            </div>
        </div> -->

    </section>
   
    <!-- Jquery needed -->

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Function used to shrink nav bar removing paddings and adding black background -->
    <script>
        function table_report() {
            window.open("http://localhost/project/table_report.php");

        }
        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
            }
        });
        document.getElementById("date_start").onchange = function() {
            var input = document.getElementById("date_end");
            input.setAttribute("min", this.value);
        }
        console.log(document.getElementById("location").value);
        var ctx = document.getElementById("myChart").getContext('2d');
        var color_point = "";
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $datesave; ?>

                ],
                datasets: [{
                    label: "<?php echo $type; ?>",
                    data: [<?php echo $totol; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 255, 255, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],

                    borderColor: [color_point],
                    pointBorderColor: [
                        <?php echo $color; ?>
                    ],
                    pointBackgroundColor: [
                        <?php echo $color; ?>
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        function generatePDF() {
            // Choose the element that our invoice is rendered in.
            const element = document.getElementById("invoice");
            // Choose the element and save the PDF for our user.
            html2pdf()
                .from(element)
                .save();
        }
    </script>
</body>

</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');

    .btn_download {
        border-radius: 10px;
        margin-top: 10px;
        width: 70%;
        font-size: 20px;
    }

    .btn_download:hover {
        background-color: #5DADE2;
        border: 0;
        color: #fff;
    }

    #myChart {

        background-color: #fff;
        border-radius: 10px;
    }

    .home {
        box-sizing: border-box;
        font-family: 'Mitr', sans-serif;
    }

    .col1 {
        padding: 20px 30px 20px 30px;
        border-radius: 20px;
        background-color: #fff;

    }

    .col2 {
        border-radius: 20px;

    }

    .conten {
        padding: 15% 70px 70px 70px;

    }

    .wording {
        font-size: 50px;
        padding-top: 15%;
        color: #fff;
        width: 30%;
        height: 200px;
        text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.55);
    }

    .wel {
        margin-left: 10%;
        padding-top: 15%;
    }

    .button {
        height: 20%;
        width: 10%;
    }

    /*******************************************************************/


    p {
        margin-bottom: 0.5em;
    }

    a,
    a:visited {
        text-decoration: none;
        color: #00AE68;
    }

    .clear {
        clear: both;
    }




    .pageSubTitle {
        margin-bottom: 0.5em;
        font-size: 10%;
        font-weight: 700;
        line-height: 1em;
        color: #222;
    }

    .articleTitle {
        font-size: 10%;
        font-weight: 700;
        line-height: 1em;
        color: #222;
    }

    .wrapper {
        width: 600px;
    }




    a.button {
        display: block;
        float: left;
        width: 20%;
        padding: 0;
        margin: 10px 20px 10px 0;
        font-weight: 1000;
        text-align: center;
        line-height: 50px;
        color: #FFF;
        border-radius: 5px;
        transition: all 0.2s;
        -webkit-box-shadow: 0px 0px 8px -5px #000000;
        box-shadow: 0px 0px 8px -5px #000000;
    }

    .btnBlueGreen {
        /* For browsers that do not support gradients */
        background: -webkit-linear-gradient(left top, #FF4E50, #F9D423);
        /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(bottom right, #FF4E50, #F9D423);
        /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(bottom right, #FF4E50, #F9D423);
        /* For Firefox 3.6 to 15 */
        background: linear-gradient(to bottom right, #FF4E50, #F9D423);
        /* Standard syntax */
    }

    .btnLightBlue {
        background: #5DC8CD;
    }

    .btnOrange {
        background: #FFAA40;
    }

    .btnPurple {
        background: #A74982;
    }

    /* FADE */
    .btnFade.btnBlueGreen:hover {
        background: #DBD5A4;
        color: #000;
    }

    .btnFade.btnLightBlue:hover {
        background: #01939A;
    }

    .btnFade.btnOrange:hover {
        background: #FF8E00;
    }

    .btnFade.btnPurple:hover {
        background: #6D184B;
    }

    /* 3D */
    .btnBlueGreen.btnPush {
        box-shadow: 0px 5px 0px 0px #007144;
    }

    .btnLightBlue.btnPush {
        box-shadow: 0px 5px 0px 0px #1E8185;
    }

    .btnOrange.btnPush {
        box-shadow: 0px 5px 0px 0px #A66615;
    }

    .btnPurple.btnPush {
        box-shadow: 0px 5px 0px 0px #6D184B;
    }

    .btnPush:hover {
        margin-top: 15px;
        margin-bottom: 5px;
    }

    .btnBlueGreen.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #007144;
    }

    .btnLightBlue.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #1E8185;
    }

    .btnOrange.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #A66615;
    }

    .btnPurple.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #6D184B;
    }

    /* BORDER */
    .btnBlueGreen.btnBorder {
        box-shadow: 0px 0px 0px 0px #21825B;
    }

    .btnBlueGreen.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #21825B;
    }

    .btnLightBlue.btnBorder {
        box-shadow: 0px 0px 0px 0px #01939A;
    }

    .btnLightBlue.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #01939A;
    }

    .btnOrange.btnBorder {
        box-shadow: 0px 0px 0px 0px #A66615;
    }

    .btnOrange.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #A66615;
    }

    .btnPurple.btnBorder {
        box-shadow: 0px 0px 0px 0px #6D184B;
    }

    .btnPurple.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #6D184B;
    }

    /* FLOAT */
    .btnFloat {
        background: none;
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.5);
    }

    .btnFloat:before {
        content: 'Float';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 120px;
        height: 50px;
        border-radius: 5px;
        transition: all 0.2s;
    }

    .btnBlueGreen.btnFloat:before {
        background: #00AE68;
    }

    .btnLightBlue.btnFloat:before {
        background: #5DC8CD;
    }

    .btnOrange.btnFloat:before {
        background: #FFAA40;
    }

    .btnPurple.btnFloat:before {
        background: #8D336A;
    }


    .btnFloat:before {
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.4);
    }



    .btnFloat:hover:before {
        margin-top: -2px;
        margin-left: 0px;
        transform: scale(1.1, 1.1);
        -ms-transform: scale(1.1, 1.1);
        -webkit-transform: scale(1.1, 1.1);
        box-shadow: 0px 5px 5px -2px rgba(0, 0, 0, 0.25);
    }

    /* SLIDE */
    .btnSlide.btnBlueGreen {
        background: 0;
    }

    .btnSlide .top {
        position: absolute;
        top: 0px;
        left: 0;
        width: 120px;
        height: 50px;
        background: #00AE68;
        z-index: 10;
        transition: all 0.2s;
        border-radius: 5px;
    }

    .btnSlide.btnBlueGreen .top {
        background: #00AE68;
    }

    .btnSlide.btnLightBlue .top {
        background: #5DC8CD;
    }

    .btnSlide.btnOrange .top {
        background: #FFAA40;
    }

    .btnSlide.btnPurple .top {
        background: #A74982;
    }

    .btnSlide .bottom {
        position: absolute;
        top: 0;
        left: 0;
        width: 120px;
        height: 50px;
        color: #000;
        z-index: 5;
        border-radius: 5px;
    }

    .btnSlide:hover .top {
        top: 40px;
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
        background-image: url(./images/bg33.jpg);
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


    input[type="date"]::-webkit-clear-button {
        display: none;
    }

    /* Removes the spin button */
    input[type="date"]::-webkit-inner-spin-button {
        display: none;
    }

    /* Always display the drop down caret */
    input[type="date"]::-webkit-calendar-picker-indicator {
        color: #2c3e50;
    }

    /* A few custom styles for date inputs */
    input[type="date"] {
        appearance: none;
        -webkit-appearance: none;
        color: #95a5a6;
        font-family: "Helvetica", arial, sans-serif;
        font-size: 18px;
        border: 1px solid #ecf0f1;
        background: #ecf0f1;
        padding: 5px;
        display: inline-block !important;
        visibility: visible !important;
    }

    input[type="date"],
    focus {
        color: #95a5a6;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
    }

    div.c {
  text-align: right;
} 

#circle_red {
width: 10px; /* ความกว้าง */
height: 10px; /* ความสูง */
background: red; /* สี */
-moz-border-radius: 70px;
-webkit-border-radius: 70px;
border-radius: 70px;

}
#circle_green {
width: 10px; /* ความกว้าง */
height: 10px; /* ความสูง */
background: green; /* สี */
-moz-border-radius: 70px;
-webkit-border-radius: 70px;
border-radius: 70px;

}
</style>

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