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


$No_sen_s = $_GET["no_sensor"];

$username_ses_s = $_SESSION['username'];




$sql = "SELECT * FROM sensor where User_use = '$username_ses_s' and No =$No_sen_s   ";
$result = mysqli_query($link, $sql);
while ($row_sen = mysqli_fetch_array($result)) {
    $No_sensor_s[] = $row_sen['No'];
    $name_sen_s[] = $row_sen['Name_sensor'];
    $detail_s[] =  $row_sen['Detail'];
    $img_s[] = $row_sen['img'];
    $topic_s[] = $row_sen['topic'];
    $on_off_s[] = $row_sen['On_off'];
    $status_s[] = $row_sen['status'];
    $no_location_s[] = $row_sen['No_location'];
    $set_val1_s[] = $row_sen['set_val1'];
    $set_val2_s[] = $row_sen['set_val2'];
    $set_val3_s[] = $row_sen['set_val3'];
    $set_val4_s[] = $row_sen['set_val4'];
    $type_s[] = $row_sen['type'];
    $save_time_s[] = $row_sen['save_time'];

    
    $start_val1_s[] = $row_sen['start_val1'];
    $start_val2_s[] = $row_sen['start_val2'];
}


mysqli_close($link);
?>

<script src="paho-mqtt.js"></script>

<script>
   client5 = new Paho.MQTT.Client("hairdresser.cloudmqtt.com", Number(35673), "clientId5");
   client5Y = new Paho.MQTT.Client("hairdresser.cloudmqtt.com", Number(35673), "clientId5Y");

    client5.onConnectionLost = onConnectionLost5;
    client5.onMessageArrived = onMessageArrived5;

    client5Y.onConnectionLost = onConnectionLost5Y;
    client5Y.onMessageArrived = onMessageArrived5Y;

    client5.connect({
        useSSL: true,
        userName: "keppjuyb",
        password: "9ZHB0HfkBKEx",
        onSuccess: onConnect5
    });

    client5Y.connect({
        useSSL: true,
        userName: "keppjuyb",
        password: "9ZHB0HfkBKEx",
        onSuccess: onConnect5Y
    });

    function onConnect5() {
        console.log("onConnect5");
        client5.subscribe("TEST/MQTT_GYRO_X");
        message = new Paho.MQTT.Message(" - ");
        message.destinationName = "TEST/MQTT_GYRO_X";
        client5.send(message);
    }

    function onConnect5Y() {
        console.log("onConnect5Y");
        client5Y.subscribe("TEST/MQTT_GYRO_Y");
        message = new Paho.MQTT.Message(" - ");
        message.destinationName = "TEST/MQTT_GYRO_Y";
        client5Y.send(message);
    }

    function onConnectionLost5(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived5(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)

        document.getElementById('X_GYRO').value = message.payloadString ;
    }

    function onConnectionLost5Y(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived5Y(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)

        document.getElementById('Y_GYRO').value = message.payloadString ;
    }

      



</script>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ปรับแต่งอุปกรณ์(<?php echo $name_sen_s[0]?>)</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/settings.png" />

    <script src="https://dribbble.com/shots/2536070-Jelly-Buttons-CSS"></script>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</head>

<body>
    <nav class="nav">
        <div class="container-fluid navbarr">
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
                        echo "  <li><a href='profile.php'>เชื่อมต่อLINE</a></li>";
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
<div class="container conten">
  <div class="row">
    <div style="background-color:#1C1C1C" class="col-8 ">
    <div class="head_sen" style="font-size:30px ; color:#fff">ปรับแต่งอุปกรณ์</div>
            
      <div  style="height:60%"class="row">
        <div style="background-color:#585858" class="col-3 ">
            <img style=""  src="./images/<?php echo $img_s[0] . ".png" ?>" alt="" height="100%" width="100%">
</div>
        <div  style="background-color:#C3C3C3" class="col-9 ">
                                <?php
                                //::set_HDT11:://
                                if ($on_off_s[0] == 0 && $status_s[0] == 0 && $type_s[0]=== "DHT11") {
                                    echo "<h1 style='color:red'> กรุณาเปิดการใช้งานอุปกรณ์ก่อน </h1>";
                                     } else {


                                    if ($type_s[0] === "DHT11") {
                                        if ($set_val1_s[0] == null && $set_val2_s[0] == null) {
                                            $set_val1_s[0] = "<small style='color:red'>ยังไม่กำหนด</small>";
                                            $set_val2_s[0] = "<small style='color:red'>ยังไม่กำหนด</small>";
                                        }
                                        echo '<div class="container">
                                           <h3><b>ค่าที่กำหนดไว้</b></h3>
                                           <form action="process_set_val_DHT11.php" method="post">
                                            <div class="row">
                                              <div class="col-sm-3">
                                              <h4>ค่าต่ำสุด : ' . $set_val1_s[0] . '</h4>
                                               <input name="in1_DHT11" step="0.01" type="number" id="in1" min=1 max=50 required placeholder="ใส่ค่า">
                                              </div>
                                              <div class="col-sm-3">
                                              <h4>ค่าสูงสุด : ' . $set_val2_s[0] . '</h4>
                                             
                                             <input name="in2_DHT11" step="0.01" type="number" id="in2" min=1 max=50 required placeholder="ใส่ค่า"> 
                                             <input type="number" value="' . $No_sen_s[0] . '" name="No_location" hidden>
                                              </div>

                                              <div class="col-sm-6">
                                             
                                              <div style="font-size:15px"><b>หมายเหตุ</b>
                                           เนื่องด้วยอุปกรณ์ DHT11 สามารถวัดค่าระหว่าง 1°C ถึง 50°C เท่านั้น 
                                           </div>
                                          
                                              </div>
                                             
                                            </div><br>
                                           
                                          </div>
                                         <center> <button class="button" type="submit"  id="set_val"><span>บันทึก</span></button></center>
                                          </form>';
                                          
                                          }
                                }
                                //:: SOIL :: //
                                if ($on_off_s[0] == 0 && $status_s[0] == 0 && $type_s[0]=== "SOIL") {
                                    echo "<h1 style='color:red'> กรุณาเปิดการใช้งานอุปกรณ์ก่อน </h1>";
                                   
                                } else {
                                    if ($type_s[0] === "SOIL") {
                                        if ($set_val1_s[0] == null) {
                                            $set_val1_s[0] = "<small style='color:red'>ยังไม่กำหนด</small>";
                                        }
                                        echo '<div class="container">
                                        <b><h4>ค่าที่กำหนดไว้</h4></b>
                                           <form action="process_set_val_SOIL.php" method="post">
                                            <div class="row">
                                              <div class="col-sm-12">
                                              <h2>เกณฑ์ที่กำหนด : ' . $set_val1_s[0] . ' %</h2>
                                               <input name="in1_SOIL"  type="number" id="in1" min=1 max=100 required placeholder="ใส่ค่า">
                                              </div>
                                             
                                             <input type="number" value="' . $No_sen_s[0] . '" name="No_location" hidden>
                                             
                                            </div><br>
                                            <h5><b>หมายเหตุ</b>: จะทำการแจ้งเตือนเมื่อ<span style="color:red"><b>เกินเกณฑ์</b></span>ที่กำหนดไว้ %</h5>
                                          </div>
                                          <button class="button" type="submit"  id="set_val">บันทึก</button>
                                          </form><br>
                                          ';
                                    }
                                }

                                 //:: WATER :: //
                                 if ($on_off_s[0] == 0 && $status_s[0] == 0 && $type_s[0]=== "WATER") {
                                    echo "<h1 style='color:red'> กรุณาเปิดการใช้งานอุปกรณ์ก่อน </h1>";
                                     } else {
                                    if ($type_s[0] === "WATER") {
                                        if ($set_val1_s[0] == null) {
                                            $set_val1_s[0] = "<small style='color:red'>ยังไม่กำหนด</small>";
                                        }
                                        echo '<div class="container">
                                        <b><h4>ค่าที่กำหนดไว้</h4></b>
                                           <form action="process_set_val_WATER.php" method="post">
                                            <div class="row">
                                              <div class="col-sm-12">
                                              <h2>เกณฑ์ที่กำหนด : ' . $set_val1_s[0] . ' %</h2>
                                               <input name="in1_WATER"  type="number" id="in1" min=1 max=100 required placeholder="ใส่ค่า">
                                              </div>
                                             
                                             <input type="number" value="' . $No_sen_s[0] . '" name="No_location" hidden>
                                             
                                            </div><br>
                                            <h5><b>หมายเหตุ</b>: จะทำการแจ้งเตือนเมื่อ<span style="color:red"><b>เกินเกณฑ์</b></span>ที่กำหนดไว้ %</h5>
                                          </div>
                                          <button class="button" type="submit"  id="set_val">บันทึก</button>
                                          </form><br>
                                         ';
                                    }
                                }

                                    //:: RAIN :: //
                                    if ($on_off_s[0] == 0 && $status_s[0] == 0 && $type_s[0]=== "RAIN") {
                                        echo "<h1 style='color:red'> กรุณาเปิดการใช้งานอุปกรณ์ก่อน </h1>";
                                       } else {
                                        if ($type_s[0] === "RAIN") {
                                            if ($set_val1_s[0] == null) {
                                                $set_val1_s[0] = "<small style='color:red'>ยังไม่กำหนด</small>";
                                            }
                                            echo '<div class="container">
                                            <b><h4>ค่าที่กำหนดไว้</h4></b>
                                               <form action="process_set_val_RAIN.php" method="post">
                                                <div class="row">
                                                  <div class="col-sm-12">
                                                  <h2>เกณฑ์ที่กำหนด : ' . $set_val1_s[0] . ' %</h2>
                                                   <input name="in1_RAIN"  type="number" id="in1" min=1 max=100 required placeholder="ใส่ค่า">
                                                  </div>
                                                 
                                                 <input type="number" value="' . $No_sen_s[0] . '" name="No_location" hidden>
                                                 
                                                </div><br>
                                                <h5><b>หมายเหตุ</b>: จะทำการแจ้งเตือนเมื่อ<span style="color:red"><b>เกินเกณฑ์</b></span>ที่กำหนดไว้ %</h5>
                                              </div>
                                              <button class="button" type="submit"  id="set_val">บันทึก</button>
                                              </form><br>
                                             ';
                                        }
                                    }
    
                                      //:: GYRO :: //
                                      if ($on_off_s[0] == 0 && $type_s[0]=== "GYRO") {
                                        echo "<h1 style='color:red'> กรุณาเปิดการใช้งานอุปกรณ์ก่อน </h1>";
                                       }else {
                                              if ($type_s[0] === "GYRO" ) {
                                if ($start_val1_s[0] == 0 || $start_val2_s[0] == 0  ) {
                                    echo "<h2 style='color:red'>รีเซ็ตค่า <img src='./images/gyro_wrog.png' alt='' srcset='' width='20' height='20' ></h2>";
                                }
                                if ($start_val1_s[0] != 0 && $start_val2_s[0] != 0) {
                                    echo "<h2 style='color:green'>เซ็ตค่า <img src='./images/gyro_success.png' alt='' srcset=''  width='20' height='20'></h2>";
                                }
                                if ($set_val1_s[0] == null  && $set_val2_s[0] == null) {
                                    echo "<h2 style='color:red'>กำหนดค่า  <img src='./images/gyro_wrog.png' alt='' srcset='' width='20' height='20' ></h2>";
                                }
                               
                                if ($start_val1_s[0] != 0 && $start_val2_s[0] != 0  && $set_val1_s[0] != null && $set_val2_s[0] != null) {
                                    echo "<h2 style='color:green'>กำหนดค่า <img src='./images/gyro_success.png' alt='' srcset=''  width='20' height='20'></h2>";

                                    echo '<h4>แกน X : อยู่ระหว่าง ' . $set_val3_s[0] . ' ถึง '.$set_val1_s[0].'</h4>';
                                    echo '<h4>แกน Y : อยู่ระหว่าง ' . $set_val4_s[0] . ' ถึง '.$set_val2_s[0].'</h4>';
                                }

                                echo '<div class="container">
                                      
                                        <form action="process_set_val_GYRO.php" method="post">
                                         <div class="row">
                                           <div class="col-sm-3">';
                                           
                                if ($start_val1_s[0] == 0 && $start_val2_s[0] == 0 ) {

                                    echo '<h4>แกน X :' . $set_val1_s[0] . ' </h4>
                                                  
                                                   <input style="width:100%"  id="X_GYRO"  name="X_GYRO" >
                                                   </div>
                                                   <div class="col-sm-3">
                                                   <h4>แกน Y : ' . $set_val2_s[0] . '</h4>
                                                   <input style="width:100%"   id="Y_GYRO"  name="Y_GYRO"   >
                                                  <input type="number" value="' . $No_sen_s[0] . '" name="No_location" hidden>';
                                                  
                                } 
                                else if($start_val1_s[0] != 0 && $start_val2_s != 0 && $set_val1_s[0] ==0 && $set_val2_s[0] ==0   ){
                                    echo '<h4>แกน X : ' . $set_val1_s[0] . '</h4>

                                            <input name="input_gyro_x" step="0.01" type="number" id="in1_gyro" min=1 max=180 required placeholder="X+">
                                            <input name="input_gyro_x_Negative" step="0.01" type="number" id="in1_gyro" min=-180 max=-1 required placeholder="X-">
                                           </div>
                                           <div class="col-sm-3">
                                           <h4>แกน Y : ' . $set_val2_s[0] . '</h4>
                                          
                                          <input name="input_gyro_y" step="0.01" type="number" id="in2_gyro" min=1 max=180 required placeholder="Y+"> 
                                          <input name="input_gyro_y_Negative" step="0.01" type="number" id="in2_gyro" min=-180 max=1 required placeholder="Y-"> 
                                          <input type="number" value="' . $No_sen_s[0] . '" name="No_location" hidden>';
                                }
                                echo '</div>
                                           <div class="col-sm-6">
                                          
                                           <div style="font-size:15px"><b>หมายเหตุ</b>
                                           กดปุ่ม เซ็ตค่าเริ่มต้น หลังจากติดตั้งอุปกรณ์ <br>(ควรให้ค่าแกน X และ Y คงที่ก่อน)
                                        </div>
                                           </div>
                                         </div><br>
                                       </div>
                                      <center> ';
                                      if ($start_val1_s[0] != 0 && $start_val2_s != 0 && $set_val1_s[0] ==0 && $set_val2_s[0] ==0) {
                                        echo ' <button class="button" type="submit"  id="set_val"><span>บันทึก</span></button>';
                                      }else if($set_val1_s[0] == 0 || $set_val2_s[0] == 0 &&  $start_val1_s[0] == 0 && $start_val2_s[0] == 0) {
                                        //   echo '<input type="number" value="' . $No_sen_s[0] . '" name="delete_start" hidden>';
                                        // echo ' <button id="set_val" type="submit" class="btn-danger">ตั้งค่าใหม่</button>';
                                        echo ' <input type="number" value="' . $no_location_s[0] . '" name="No_location_sss" hidden>';
                                        echo ' <button style="background-color:#F4D03F" class="button" type="submit"  id="set_val"><span>เซ็ตค่า</span></button>';

                                        //echo ' <button class="button" type="submit"  id="set_val"><span>บันทึก</span></button>';
                                      }

                                      if($set_val1_s[0] != null && $set_val2_s[0] != null ){
                                        echo '<input type="number" value="' . $No_sen_s[0] . '" name="delete_start" hidden>';
                                        
                                        echo ' <button id="set_val" type="submit" class="btn-danger">ตั้งค่าใหม่</button>';
                                      }
                                    
                                    
                                     echo '</center>
                                       </form>';

                                //     echo '<div class="row">
                                //     <div class="col-sm-4">.col-sm-4</div>
                                //     <div class="col-sm-4">';
                                //         if($set_val1_s[0] != null && $set_val2_s != null){
                                //             echo ' <button type="button" class="btn btn-success">เซ็ตค่าเริ่มต้น</button>';
                                //         }else {
                                //             echo ' <button type="button" class="btn btn-danger">ตั้งค่าใหม่</button>';
                                //         }


                                //     echo '</div>
                                //     <div class="col-sm-4"> 

                                //     <h4>กดปุ่ม เซ็ตค่าเริ่มต้น หลังจากติดตั้งอุปกรณ์</h4>

                                //     </div>
                                //   </div>';
                            }
                                       }
                         
                            ?>



                                
                                </div>
      </div>
    </div>
    <div style="background-color:#6AB263" class="col-4">
        <center> <h1>กำหนดเวลาการเก็บข้อมูล / นาที</h1>
        <h3>จะทำการเก็บข้อมูลทุก ๆ <span style="color:red"><?php echo $save_time_s[0] ?> </span>นาที</h3>
        <form action="process_update_savetime.php" method='post'>
            <select name="save_time" id="save_time" class="save_time">
              
                <?php 
                    for ($i=1; $i <=60 ; $i++) { 
                      echo  '<option value="'.$i.'">'.$i.'</option>';
                    }
                ?>

            </select><br><br>
            <input type="number" name="no_sensor" id="" value="<?php echo $No_sensor_s[0]?>" hidden>
            <button class="button" type="submit"  id="set_val"><span>บันทึก</span></button>
        </form></center>
</div>
  </div>
  <center>
 
  <button style ="padding-top:1%;width:19%; height:5%" onclick="back(<?php echo $no_location_s[0]?>)" class="button_back" type="submit" id="back"><span>กลับ</span></button><br>
  <a  style="height:5%" type="submit"href="" class="btn button"  data-toggle="modal" data-target=".bd-example-modal-lg"> วิธีการกำหนดค่า</a>
  
  
</center>;
                                 
</div>


<!-- Large modal -->

      


<div style="padding-top:10% ;" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php 
              if($type_s[0] == 'DHT11' ){
                  echo '<img src="./images/setting_dht11.png" alt="" srcset="" height="400px" >';
              }
              if($type_s[0] == 'SOIL' ){
                echo '<img src="./images/setting_soil.png" alt="" srcset="" height="400px" >';
            }
            if($type_s[0] == 'WATER' ){
                echo '<img src="./images/setting_water.png" alt="" srcset="" height="400px" >';
            }
            if($type_s[0] == 'RAIN' ){
                echo '<img src="./images/setting_rain.png" alt="" srcset="" height="400px" >';
            }
            if($type_s[0] == 'GYRO' ){
                echo '<img src="./images/setting_gyro.png" alt="" srcset="" height="400px" >';
            }
        ?>
      
    </div>
  </div>
</div>


      
    </section>
    </body>
    </html>
    <!-- Jquery needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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

        $("#in1").blur(function() {
            var in1 = document.getElementById('in1').value;
            in1 =
                Number(in1) + Number(0.01);
            console.log(in1);
            document.getElementById("in2").setAttribute("min", in1);
        });

        function back(val){
            window.location.assign("http://localhost/project/show_sensor.php?No_lo="+val+"")
            console.log(val);
        }
    </script>
<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');
#X_GYRO{
    color:chocolate;
    border:0;
    background: none;
    font-size:20px ; 
    width:50%;
    height:50%;
}
#Y_GYRO{
    color:chocolate;
    border:0;
    background: none;
    font-size:20px ; 
    width:50%;
    height:50%;
}

.conten{
    padding:200px 40px 0 40px;
    
}
.save_time{
    text-align: center;
    height: 30px;
    width: 50px;
    font-size: 15px;
    border-radius: 10px;
}
.save_time:focus{
    background-color: #5B5B5B;
    color:white;
}

.col-9{
padding:10px;
border-radius: 10px;
}

.col-3{
   padding:10px 25px 10px 25px;
    border-radius: 10px;

}
.col-4{
    padding-top:3%;
    border-radius: 10px;

}
.col-8{
    border-radius: 10px;
}



    .head_sen {
        text-shadow: 0px 0px 4px rgba(0, 0, 0, 0.77);
        color: #FFFFFF;
    }


    .col-sm-9 {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin: 10px;

    }



    .con_sen {
        padding-top: 150px;
    }

    .home {
        box-sizing: border-box;
        font-family: 'Mitr', sans-serif;
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
    html,
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Mitr', sans-serif;
        font-size: 62.5%;
        

    }

    /*-- Inspiration taken from abdo steif -->
/* --> https://codepen.io/abdosteif/pen/bRoyMb?editors=1100*/
    /* Navbar section */
    .nav {
        width: 100%;
        height: 90px;
        position: fixed;
        line-height: 65px;
        text-align: center;
        background-color: black;
        padding-bottom: 10px;
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
        height: 100%;
        background-color: #404040;
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

    #in1,
    #in2 {
        height: 30px;
        width: 100px;
        border-radius: 10px;
        text-align: center;
        font-size: 20px;
    }
    #in1:focus{
        background-color: #E5E8E8;
    
    }
    #in2:focus{
        background-color: #E5E8E8;
    
    }

    #in1_gyro,
    #in2_gyro {
        height: 30px;
        width: 100px;
        border-radius: 10px;
        text-align: center;
        font-size: 20px;
    }
    #in1_gyro:focus{
        background-color: #E5E8E8;
    
    }
    #in2_gyro:focus{
        background-color: #E5E8E8;
    
    }

    #set_val {
        height: 30px;
        width: 100px;
        font-size: 15px;
        border-radius: 10px;
    }



    .button {
border-radius: 4px;
background-color: #28B463 ;
border: none;
color: #fff;
text-align: center;
font-size: 20px;
padding: 5px;
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
content: '\21E5';
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


.button_back {
border-radius: 4px;
background-color: #DC7633 ;
border: none;
color: #fff;
text-align: center;
font-size: 15px;
padding: 1px;
width: 90px;
height: 30px;
transition: all 0.5s;
cursor: pointer;
margin: 2px;
}

.button_back span {
cursor: pointer;
display: inline-block;
position: relative;
transition: 0.5s;
}

.button_back span:after {
content: '\21BB';
position: absolute;
opacity: 0;
top: 0;
right: -20px;
transition: 0.5s;
}



.button_back:hover span {
padding-right: 25px;

}

.button_back:hover span:after {
opacity: 1;
right: 0;
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