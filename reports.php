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
if ($_POST["code"]) {
    $code_input = $_POST['code'];
    $location_input = $_POST['location'];
    $con = mysqli_connect("localhost", "root", "", "myproject") or die("Error: " . mysqli_error($con));
    mysqli_query($con, "SET NAMES 'utf8' ");
    $query = "SELECT * FROM report_all where code ='$code_input'and location = $location_input ";
    $result = mysqli_query($con, $query);
    $resultchart = mysqli_query($con, $query);
    //for chart
    $datesave = array();
    $totol = array();

    while ($rs = mysqli_fetch_array($resultchart)) {
        $datesave[] = "\"" . $rs['date'] . "\"";
        $totol[] = "\"" . $rs['value1'] . "\"";
    }
    echo count($totol);
    if (count($totol) == 0) {
        echo "<h1>ไม่พบอุปกรณ์</h1>";
    }

    $datesave = implode(",", $datesave);
    $totol = implode(",", $totol);

?>


<?php
    mysqli_close($con);
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>setting sensor</title>
    <script src="script2.js"></script>
    <script src="https://dribbble.com/shots/2536070-Jelly-Buttons-CSS"></script>

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="html2pdf.bundle.min.js"></script>
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


    <section class="home">
        <center>
            <form class="locate" action="" method="post">
                <a style="color:#fff;font-size:200%;">การเรียกดูข้อมูลย้อนหลังชนิดกราฟ (เลือกตาม - สถานที่/เซ็นเซอร์/วันที่)</a>
                <div class="row" style="padding-top:3%;">
                    <div class="col-1"></div>
                    <div class="col-10 pn">
                        <div class="row" style="margin-top:30px;">
                            <div class="col-2">
                                <div class="textse">สถานที่เรียกดู :</div>
                            </div>
                            <div class="col-4">
                                <select name="location" id="" class="dropdown btn btn-secondary btn-lg dropdown-toggle" required>
                                    <option value="">กรุณาเลือกสถานที่ </option>
                                    <?php
                                    if ($No != null) {
                                        for ($i = 0; $i < count($No); $i++) {
                                            echo '<option value="' . $No[$i] . '">' . $name_location[$i] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <div class="textse">เซ็นเซอร์เรียกดู :</div>
                            </div>
                            <div class="col-4">

                                <div class="dropdown">

                                    <select name="code" id="" class="dropdown btn btn-secondary btn-lg dropdown-toggle" required="">
                                        <option value="">กรุณาเลือกเซ็นเซอร์ </option>
                                        <?php
                                        if ($No_sensor != null) {
                                            for ($i = 0; $i < count($No_sensor); $i++) {
                                                echo '<option value="' . $code[$i] . '">' . $name_sen[$i] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:30px;">
                            <div class="col-2">
                                <div class="textse"> เดือน/วัน/ปี :</div>
                            </div>
                            <div class="col-3">
                                <input type="date" id="date_start" name="date_start" max="<?php $date_validation = date("Y-m-d");
                                                                                            echo $date_validation; ?>" required>

                            </div>
                            <div class="col-1">
                                <h2><b> ถึง</b></h2>
                            </div>
                            <div class="col-3">
                                <input type="date" id="date_end" name="date_end" max="<?php $date_validation = date("Y-m-d");
                                                                                        echo $date_validation; ?>" required>
                            </div>
                            <div class="col-3">

                                <button type="submit" class="btn btn-lg btn-success" style="background-color: #45D33A;">ค้นหา</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <div calss='graph' id="graph">
                <canvas id="myChart" width="1000px" height="300px"></canvas>
                <button type="submit" id="print">พิมพ์รายงาน</button>
            </div>

        </center>
    </section>
    <div style="height: 200px;background:#151515">
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>

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

        document.getElementById("date_start").onchange = function() {
            var input = document.getElementById("date_end");
            input.setAttribute("min", this.value);
        }

        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $datesave; ?>

                ],
                datasets: [{
                    label: 'ค่าที่ได้รับจากเซนเซอร์',
                    data: [<?php echo $totol; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
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

        $("#print").click(function() {
            w = window.open();
            w.document.write($('.graph').html());
            w.print();
          
        });
    </script>



    <style>
        @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');


        #myChart {
            padding: 50px;
            background-color: #B2C1F9;
            border-radius: 10px;
            width: 80%;


        }

        .graph {
            padding: 10px;
        }

        /* Removes the clear button from date inputs */
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

        html,
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Mitr', sans-serif;
            font-size: 62.5%;
            font-size: 10px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        /*-- Inspiration taken from abdo steif -->
/* --> https://codepen.io/abdosteif/pen/bRoyMb?editors=1100*/

        /* Navbar section */
        .dropdown-menu {
            width: 80%;
        }

        .col-2 {

            padding-top: 10px;
            padding-bottom: 10px;
        }

        .col-4 {

            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 0px;
        }

        .col-3 {
            padding-top: 10px;
            padding-bottom: 10px;

        }

        .col-1 {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .textse {
            font-size: 16px;
            margin-left: 25px;
        }

        .btnsub {
            background-color: #45D33A;
        }

        .btn {
            width: 80%;
            background-color: #C9C9C9;
            border: none;
            margin-left: -20px;

        }

        .locate {
            padding-top: 10%;
            width: 85%;
        }

        .pn {
            height: 200px;
            width: 700px;
            border-radius: 25px;
            background-color: #FAFAFA;
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
            height: 100%;
            background-color: #151515;
            background-position: center top;
            background-size: cover;
            border: 0cm;
            margin: 0;


        }

        .navTrigger {
            display: none;
        }

        .nav {
            padding-top: 20px;
            padding-bottom: 20px;
            -webkit-transition: all 0.4s ease;
            transition: all 0.4s ease;
            z-index: 2048;
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



</body>

</html>