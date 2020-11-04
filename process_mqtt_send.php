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

$sql_sen = "SELECT * FROM users where username = '$username_ses'  ";
$result_sen = mysqli_query($link, $sql_sen);
while ($row_sen = mysqli_fetch_array($result_sen)) {
    $line[] = $row_sen['line'];
    $place_use[] = $row_sen['place_use'];
}



$sql_sen = "SELECT * FROM sensor where User_use = '$username_ses' and status!=0 ";
$result_sen = mysqli_query($link, $sql_sen);
while ($row_sen = mysqli_fetch_array($result_sen)) {
    $No_sensor[] = $row_sen['No'];
    $name_sen[] = $row_sen['Name_sensor'];
    $detail[] =  $row_sen['Detail'];
    $img[] = $row_sen['img'];
    $topic[] = $row_sen['topic'];
    $no_location[] = $row_sen['No_location'];
    $on_off[] = $row_sen['On_off'];
    $status[] = $row_sen['status'];
    $type[] = $row_sen['type'];
    $save_time[] = $row_sen['save_time'];
    $set_val1[] = $row_sen['set_val1'];
    $set_val2[] = $row_sen['set_val2'];
    $set_val3[] = $row_sen['set_val3'];
}





$val1_DHT11 = "start";
$val2_DHT11 = "start";
$on_of_DHT11 = 0;
$no_location_DHT11 = "start";
$save_time_DHT11 = 'start';
$typess_DHT11 = "start";


$val1_SOIL = "start";
$on_of_SOIL = 0;
$no_location_SOIL = "start";
$save_time_SOIL = 'start';
$typess_SOIL = "start";


$val1_WATER = "start";
$on_of_WATER = 0;
$no_location_WATER = "start";
$save_time_WATER = 'start';
$typess_WATER = "start";



$val1_RAIN = "start";
$on_of_RAIN = 0;
$no_location_RAIN = "start";
$save_time_RAIN = 'start';
$typess_RAIN = "start";


$on_of_DHT11 = 'start';
if ($No_sensor != null) {
    for ($i = 0; $i < count($No_sensor); $i++) {
        if ($type[$i] == "DHT11" && $set_val1[$i] != null && $set_val2[$i] != null) {

            $val1_DHT11 = $set_val1[$i];
            $val2_DHT11 = $set_val2[$i];
            $typess_DHT11 = $type[$i];
            $on_of_DHT11 = $on_off[$i];
            $no_location_DHT11 = $no_location[$i];
            $save_time_DHT11 = $save_time[$i];


            $sql_sen = "SELECT * FROM the_location where username = '$username_ses' and No = $no_location_DHT11  ";
            $result_sen = mysqli_query($link, $sql_sen);
            while ($row_sen = mysqli_fetch_array($result_sen)) {
                $name_location_DHT11 = $row_sen['name_location'];
            }
        }
        if ($type[$i] == "SOIL" && $set_val1[$i] != null) {
            $val1_SOIL = $set_val1[$i];
            $typess_SOIL = $type[$i];
            $on_of_SOIL = $on_off[$i];
            $no_location_SOIL = $no_location[$i];
            $save_time_SOIL = $save_time[$i];


            $sql_sen = "SELECT * FROM the_location where username = '$username_ses' and No = $no_location_SOIL  ";
            $result_sen = mysqli_query($link, $sql_sen);
            while ($row_sen = mysqli_fetch_array($result_sen)) {
                $name_location_SOIL = $row_sen['name_location'];
            }
        }
        if ($type[$i] == "WATER" && $set_val1[$i] != null) {
            $val1_WATER = $set_val1[$i];
            $typess_WATER = $type[$i];
            $on_of_WATER = $on_off[$i];
            $no_location_WATER = $no_location[$i];
            $save_time_WATER = $save_time[$i];

            $sql_sen = "SELECT * FROM the_location where username = '$username_ses' and No = $no_location_WATER  ";
            $result_sen = mysqli_query($link, $sql_sen);
            while ($row_sen = mysqli_fetch_array($result_sen)) {
                $name_location_WATER = $row_sen['name_location'];
            }
        }
        if ($type[$i] == "RAIN" && $set_val1[$i] != null) {
            $val1_RAIN = $set_val1[$i];
            $typess_RAIN = $type[$i];
            $on_of_RAIN = $on_off[$i];
            $no_location_RAIN = $no_location[$i];
            $save_time_RAIN = $save_time[$i];

            $sql_sen = "SELECT * FROM the_location where username = '$username_ses' and No = $no_location_RAIN  ";
            $result_sen = mysqli_query($link, $sql_sen);
            while ($row_sen = mysqli_fetch_array($result_sen)) {
                $name_location_RAIN = $row_sen['name_location'];
            }
        }
    }
} else {
    // $val1_DHT11 = 0;
    // $val2_DHT11 = 0;
    // $typess_DHT11 = "DHT11";

    // $val1_SOIL = 0;
    // $typess_SOIL = "SOIL";

    // $val1_WATER = 0;
    // $typess_WATER = "RAIN";

    // $val1_RAIN = 0;
    // $typess_RAIN = "RAIN";
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="paho-mqtt.js"></script>
<script>
    var date_start = new Date;
    var minutes_start = date_start.getMinutes();
    let status = 0;
    var line_DHT11 = true;

    var date_start_SOIL = new Date;
    var minutes_start_SOIL = date_start_SOIL.getMinutes();
    let status_SOIL = 0;
    var line_SOIL = true;

    var date_start_WATER = new Date;
    var minutes_start_WATER = date_start_WATER.getMinutes();
    let status_WATER = 0;
    var line_WATER = true;

    var date_start_RAIN = new Date;
    var minutes_start_RAIN = date_start_RAIN.getMinutes();
    let status_RAIN = 0;
    var line_RAIN = true;



    client = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId");
    client2 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId2");
    client3 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId3");
    client4 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId4");
    client5 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId5");



    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client2.onConnectionLost = onConnectionLost2;
    client2.onMessageArrived = onMessageArrived2;

    client3.onConnectionLost = onConnectionLost3;
    client3.onMessageArrived = onMessageArrived3;

    client4.onConnectionLost = onConnectionLost4;
    client4.onMessageArrived = onMessageArrived4;

    client5.onConnectionLost = onConnectionLost5;
    client5.onMessageArrived = onMessageArrived5;

    ///////////////////////////
    client.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect
    });

    client2.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect2
    });

    client3.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect3
    });

    client4.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect4
    });

    client5.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect5
    });

    function onConnect() {
        console.log("onConnect");
        client.subscribe("TEST/MQTT_DHT11");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_DHT11";
        client.send(message);
    }

    function onConnect2() {
        console.log("onConnect2");
        client2.subscribe("TEST/MQTT_SOIL");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_SOIL";
        client2.send(message);
    }

    function onConnect3() {
        console.log("onConnect3");
        client3.subscribe("TEST/MQTT_WATER");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_WATER";
        client3.send(message);
    }

    function onConnect4() {
        console.log("onConnect4");
        client4.subscribe("TEST/MQTT_RAIN");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_RAIN";
        client4.send(message);
    }


    function onConnect5() {
        console.log("onConnect5");
        client5.subscribe("TEST/MQTT_GYRO");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_GYRO";
        client5.send(message);
    }

    ///////////////////////////////////////////
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived(message) {
        console.log("onMessageArrived:" + message.payloadString);

        console.log(<?php echo  $val1_DHT11 ?>);
        if (message.payloadString < <?php echo $val1_DHT11 ?> || message.payloadString > <?php echo $val2_DHT11 ?> && <?php echo $on_of_DHT11 ?> != 0) {

            //DHT11 Notify
            <?php
            $messsge_php = "❄ เซ็นเซอร์วัดอุณหภูมิ ❄  ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location_DHT11 . "   ค่าที่กำหนดไว้อยู่ระหว่าง " . $val1_DHT11 . "°C ถึง " . $val2_DHT11 . "°C  [[ ค่าปัจจุบัน ";
            ?>

            if(line_DHT11 == true){
                 $.ajax({
                type: 'GET',
                url: 'http://localhost/project/process_notify_line.php?unit=°C&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                cache: false,
            });
              line_DHT11 = false;
            }
           


            console.log(<?php echo $val1_DHT11; ?>);
            console.log(message.payloadString);
            console.log("ไม่ปกติ");
            // document.getElementById("card_location").style.borderColor = "red";
            status = 2;
            // document.getElementById("card_location").style.borderColor = "red";
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/1/2',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 1 + "/" + message.payloadString,
            });


        } else if (message.payloadString > 0 && <?php echo $on_of_DHT11 ?> != 0) {
            console.log(message.payloadString);
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/1/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 1 + "/" + message.payloadString,
            });


            status = 1
            line_DHT11 = true;
           
            console.log("ปกติ");
            // document.getElementById("card_location").style.borderColor = "green";
        }

        var date = new Date;
        var minutes = date.getMinutes();
        console.log(minutes);
        if (minutes % Number(<?php echo $save_time_DHT11; ?>) == 0 && minutes != minutes_start && <?php echo $on_of_DHT11 ?> != 0) {

            minutes_start = minutes;

            console.log("-----------------------");
            console.log(minutes_start);
            console.log(message.payloadString);
            console.log("S101");
            console.log(<?php echo $no_location_DHT11; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_DHT11; ?>);
            let code = "S101";
            let no_location = <?php echo $no_location_DHT11; ?>;
            let username = '<?php echo $username_ses; ?>';


            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status + "",
            });
        }
    }

    function onConnectionLost2(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived2(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)


        if (message.payloadString > <?php echo $val1_SOIL ?> && <?php echo $on_of_SOIL; ?> != 0) {

//SOIL Notify
            <?php
            $messsge_php = "﹏ เซ็นเซอร์ความชิ้นในดิน  ﹏ ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location_SOIL . " ค่าที่กำหนดไว้ต้องไม่เกิน " . $val1_SOIL . "% [[ ค่าปัจจุบัน ";
            ?>
             if(line_SOIL == true){
                    $.ajax({
                type: 'GET',
                url: 'http://localhost/project/process_notify_line.php?unit=%&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                cache: false,
            }); 
            line_SOIL = false;
             }
        

            
            console.log("SOIL");
            console.log(<?php echo $val1_SOIL; ?>);
            console.log(message.payloadString);
            console.log("ไม่ปกติ");
            // document.getElementById("card_location").style.borderColor = "red";
            status_SOIL = 2;
            // document.getElementById("card_location").style.borderColor = "red";
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/2/2',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 2 + "/" + message.payloadString,
            });
            
        } else if (message.payloadString > 0 && <?php echo $on_of_SOIL ?> != 0) {
            console.log(message.payloadString);
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/2/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 2 + "/" + message.payloadString,
            });
            status_SOIL = 1
            line_SOIL = true;
            console.log("ปกติ");
            // document.getElementById("card_location").style.borderColor = "green";
        }
        var date_SOIL = new Date;
        var minutes_SOIL = date_SOIL.getMinutes();

        console.log(minutes_SOIL);
        if (minutes_SOIL % Number(<?php echo $save_time_SOIL; ?>) == 0 && minutes_SOIL != minutes_start_SOIL && <?php echo $on_of_SOIL; ?> != 0) {

            minutes_start_SOIL = minutes_SOIL;

            console.log("-----------------------");
            console.log(minutes_start_SOIL);
            console.log(message.payloadString);
            console.log("S102");
            console.log(<?php echo $no_location_SOIL; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_SOIL; ?>);
            let code = "S102";
            let no_location = <?php echo $no_location_SOIL; ?>;
            let username = '<?php echo $username_ses; ?>';


            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status_SOIL + "",
            });
        }
    }

    function onConnectionLost3(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived3(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)


        if (message.payloadString > <?php echo $val1_WATER ?> && <?php echo $on_of_WATER; ?> != 0) {

//WATER Notify
            <?php
            $messsge_php = "▒ เซ็นเซอร์ระดับน้ำ ▒ ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location_WATER . " ค่าที่กำหนดไว้ต้องไม่เกิน " . $val1_SOIL . "% [[ ค่าปัจจุบัน ";
            ?>
            if(line_WATER == true){
                $.ajax({
                type: 'GET',
                url: 'http://localhost/project/process_notify_line.php?unit=%&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                cache: false,
            });
            line_WATER = false;
            }
           


            console.log("WATER");
            console.log(<?php echo $val1_WATER; ?>);
            console.log(message.payloadString);
            console.log("ไม่ปกติ");
            // document.getElementById("card_location").style.borderColor = "red";
            status_WATER = 2;
            // document.getElementById("card_location").style.borderColor = "red";
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/3/2',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 3 + "/" + message.payloadString,
            });
        } else if (message.payloadString > 0 && <?php echo $on_of_WATER ?> != 0) {
            console.log(message.payloadString);
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/3/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 3 + "/" + message.payloadString,
            });
            status_WATER = 1
            line_WATER = true;
            console.log("ปกติ");
            // document.getElementById("card_location").style.borderColor = "green";
        }
        var date_WATER = new Date;
        var minutes_WATER = date_WATER.getMinutes();

        console.log(minutes_WATER);
        if (minutes_WATER % Number(<?php echo $save_time_WATER; ?>) == 0 && minutes_WATER != minutes_start_WATER && <?php echo $on_of_WATER; ?> != 0) {

            minutes_start_WATER = minutes_WATER;
            console.log("-----------------------");
            console.log(minutes_start_WATER);
            console.log(message.payloadString);
            console.log("S103");
            console.log(<?php echo $no_location_WATER; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_WATER; ?>);
            let code = "S103";
            let no_location = <?php echo $no_location_WATER; ?>;
            let username = '<?php echo $username_ses; ?>';


            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status_WATER + "",
            });
        }
    }

    function onConnectionLost4(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived4(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)

        if (message.payloadString > <?php echo $val1_RAIN ?> && <?php echo $on_of_RAIN; ?> != 0) {

//RAIN Notify
            <?php
                $messsge_php = "☂ เซ็นเซอร์ปริมาณน้ำฝน ☂ ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location_RAIN . " ค่าที่กำหนดไว้ต้องไม่เกิน " . $val1_RAIN . "% [[ ค่าปัจจุบัน ";
                ?>

                if( line_RAIN == true){
                   $.ajax({
                    type: 'GET',
                    url: 'http://localhost/project/process_notify_line.php?unit=%&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                    cache: false,
                });  
                line_RAIN = false;
                }
               

            console.log("RAIN");
            console.log(<?php echo $val1_RAIN; ?>);
            console.log(message.payloadString);
            console.log("ไม่ปกติ");
            // document.getElementById("card_location").style.borderColor = "red";
            status_RAIN = 2;
            // document.getElementById("card_location").style.borderColor = "red";
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/4/2',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 4 + "/" + message.payloadString,
            });
        } else if (message.payloadString > 0 && <?php echo $on_of_RAIN ?> != 0) {
            console.log(message.payloadString);
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/4/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 4 + "/" + message.payloadString,
            });
            status_RAIN = 1
            line_RAIN = true;
            console.log("ปกติ");
            // document.getElementById("card_location").style.borderColor = "green";
        }

        var date_RAIN = new Date;
        var minutes_RAIN = date_RAIN.getMinutes();

        console.log(minutes_RAIN);
        if (minutes_RAIN % Number(<?php echo $save_time_RAIN; ?>) == 0 && minutes_RAIN != minutes_start_RAIN && <?php echo $on_of_RAIN; ?> != 0) {

            minutes_start_RAIN = minutes_RAIN;
            console.log("-----------------------");
            console.log(minutes_start_RAIN);
            console.log(message.payloadString);
            console.log("S104");
            console.log(<?php echo $no_location_RAIN; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_RAIN; ?>);
            let code = "S104";
            let no_location = <?php echo $no_location_RAIN; ?>;
            let username = '<?php echo $username_ses; ?>';


            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status_RAIN + "",
            });
        }
    }

    function onConnectionLost5(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived5(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)

    }
</script>