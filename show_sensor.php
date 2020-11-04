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



$No_sen = $_GET['No_lo'];
$sql = "SELECT * FROM the_location where No = '$No_sen' ";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $No[] = $row['No'];
    $name_location[] = $row['name_location'];
}
//echo $No[0];
$sql_sen = "SELECT * FROM sensor where User_use = '$username_ses' and No_location =$No_sen   ";
$result_sen = mysqli_query($link, $sql_sen);
while ($row_sen = mysqli_fetch_array($result_sen)) {
    $No_sensor[] = $row_sen['No'];
    $name_sen[] = $row_sen['Name_sensor'];
    $detail[] =  $row_sen['Detail'];
    $img[] = $row_sen['img'];
    $topic[] = $row_sen['topic'];
    $topic2[] = $row_sen['topic_2'];
    $on_off[] = $row_sen['On_off'];
    $status[] = $row_sen['status'];
    $type[] = $row_sen['type'];
    $save_time[] = $row_sen['save_time'];


    $set_val1[] = $row_sen['set_val1'];
    $set_val2[] = $row_sen['set_val2'];
    $set_val3[] = $row_sen['set_val3'];

    $start_val1_s[] = $row_sen['start_val1'];
    $start_val2_s[] = $row_sen['start_val2'];

}
//select_map
$sql_map = "SELECT * FROM map where username = '$username_ses' and No_location =$No_sen   ";
$result_map = mysqli_query($link, $sql_map);
while ($row_map = mysqli_fetch_array($result_map)) {
    $No_map[] = $row_map['No'];
    $let[] = $row_map['let'];
    $lng[] = $row_map['lng'];
}

$sql_map_name = "SELECT * FROM the_location loca JOIN map m on loca.No = m.No_location WHERE m.No_location = $No_sen";
$result_map_name = mysqli_query($link, $sql_map_name);
while ($row_map_name = mysqli_fetch_array($result_map_name)) {
    $name_loca_map[] = $row_map_name['name_location'];
}

$sql_sen = "SELECT * FROM users where username = '$username_ses'  ";
$result_sen = mysqli_query($link, $sql_sen);
while ($row_sen = mysqli_fetch_array($result_sen)) {
    $line[] = $row_sen['line'];
    $place_use[] = $row_sen['place_use'];
}

?>

<script>
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
</script>

<style>
    #map_maker {
        height: 50%;
        width: 50%;
    }
</style>
<!-- <div id="map_maker"></div> -->
<!-- <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtg-A7QGCqUpaDDHD4ptDhzp2GLvPj-BU&callback=initMap_maker">
    </script> -->
<?php

$val1_DHT11 = "start";
$val2_DHT11 = "start";
$status_DHT11 = 'start';
$time_save_DHT11 = 'start';

$val1_SOIL = "start";
$status_SOIL = 'start';
$time_save_SOIL = 'start';

$val1_WATER = "start";
$status_WATER = "start";
$time_save_WATER = "start";

$val1_RAIN = "start";
$status_RAIN = "start";
$time_save_RAIN = "start";
$typess_RAIN = "start";

$val1_GYRO_X = "start";
$val1_GYRO_Y = "start";
$status_GYRO = "start";
$time_save_RAIN = "start";
$typess_GYRO = "start";
$start_val1_s_GYRO_x = "" ;
$start_val2_s_GYRO_Y ="";


if ($No_sensor != null) {
    for ($i = 0; $i < count($No_sensor); $i++) {
        if ($type[$i] == "DHT11" && $set_val1[$i] != null && $set_val2[$i] != null) {

            $val1_DHT11 = $set_val1[$i];
            $val2_DHT11 = $set_val2[$i];
            $typess_DHT11 = $type[$i];
            $status_DHT11 = $on_off[$i];
            $time_save_DHT11 =  $save_time[$i];
        }
        if ($type[$i] == "SOIL" && $set_val1[$i] != null) {
            $val1_SOIL = $set_val1[$i];
            $typess_SOIL = $type[$i];
            $status_SOIL = $on_off[$i];
            $time_save_SOIL =  $save_time[$i];
        }
        if ($type[$i] == "WATER" && $set_val1[$i] != null) {
            $val1_WATER = $set_val1[$i];
            $typess_WATER = $type[$i];
            $status_WATER = $on_off[$i];
            $time_save_WATER =  $save_time[$i];
        }
        if ($type[$i] == "RAIN" && $set_val1[$i] != null) {
            $val1_RAIN = $set_val1[$i];
            $typess_RAIN = $type[$i];
            $status_RAIN = $on_off[$i];
            $time_save_RAIN =  $save_time[$i];
        }

        if ($type[$i] == "GYRO" && $set_val1[$i] != null && $set_val2[$i] != null) {
            $val1_GYRO_X = $set_val1[$i];
            $val1_GYRO_Y = $set_val2[$i];
            $start_val1_s_GYRO_x = $start_val1_s[$i];
            $start_val1_s_GYRO_Y = $start_val2_s[$i];
            $typess_GYRO = $type[$i];
            $status_GYRO = $on_off[$i];
            $time_save_GYRO =  $save_time[$i];
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

<!-- cloudMQTT -->
<script src="paho-mqtt.js"></script>
<script>
    var date_start = new Date;
    var minutes_start = date_start.getMinutes();
    let status_DHT11 = 0;
    var line_DHT11 = true;

    var date_start_soil = new Date;
    var minutes_start_soil = date_start_soil.getMinutes();
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

    var date_start_GYRO_X = new Date;
    var minutes_start_GYRO_X = date_start_GYRO_X.getMinutes();
    let status_GYRO_X = 0;
    var line_GYRO_X = true;

    var date_start_GYRO_Y = new Date;
    var minutes_start_GYRO_Y = date_start_GYRO_Y.getMinutes();
    let status_GYRO_Y = 0;
    var line_GYRO_Y = true;




    client = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId");
    client2 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId2");
    client3 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId3");
    client4 = new Paho.MQTT.Client("hairdresser.cloudmqtt.com", Number(35673), "clientId4");
    client5 = new Paho.MQTT.Client("hairdresser.cloudmqtt.com", Number(35673), "clientId5");
    client5Y = new Paho.MQTT.Client("hairdresser.cloudmqtt.com", Number(35673), "clientId5Y");




    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client2.onConnectionLost = onConnectionLost2;
    client2.onMessageArrived = onMessageArrived2;

    client3.onConnectionLost = onConnectionLost3;
    client3.onMessageArrived = onMessageArrived3;

    client4.onConnectionLost = onConnectionLost4;
    client4.onMessageArrived = onMessageArrived4;

 

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
        userName: "keppjuyb",
        password: "9ZHB0HfkBKEx",
        onSuccess: onConnect4
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




    ///////////////////////////////////////////
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString);
       


        if (message.payloadString < <?php echo $val1_DHT11 ?> ||
            message.payloadString > <?php echo $val2_DHT11 ?> && <?php echo $status_DHT11 ?> != 0) {

            
            $.ajax({
                dataType: "GET",
                url: "http://localhost:3000/update_value/" + 1 + "/" + message.payloadString,
            });
            status_DHT11 = 2;
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/1/2',
            });
            if (<?php echo $status_DHT11 ?> == 1) {
                 //DHT11 Notify
        <?php
                $messsge_php = "❄ แจ้งเตือนความผิดปกติ เซ็นเซอร์วัดอุณหภูมิ ❄  ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location[0] . "   ค่าที่กำหนดไว้อยู่ระหว่าง " . $val1_DHT11 . "°C ถึง " . $val2_DHT11 . "°C  [[ ค่าปัจจุบัน ";
                ?>
                if (line_DHT11 == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'http://localhost/project/process_notify_line.php?unit=°C&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                        cache: false,
                    });
                    line_DHT11 = false;
                }

                
                console.log("ไม่ปกติ");
                document.getElementById('status1').innerHTML = "<h1 style='color:red'>ผิดปกติ</h1>";
            }
        } else if (message.payloadString > 0 && <?php echo $status_DHT11 ?> != 0) {
            console.log(message.payloadString);
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 1 + "/" + message.payloadString,
            });

            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/1/1',
            });
            if (<?php echo $status_DHT11 ?> == 1) {
                line_DHT11 = true;
                console.log("ปกติ");
                document.getElementById('status1').innerHTML = "<h1 style='color:green'>ปกติ</h1>";
            }

            console.log("ปกติ");
            status_DHT11 = 1;
        }
        if (<?php echo $status_DHT11 ?> == 1) {
            document.getElementById('TEST/MQTT_DHT11').innerHTML = "<h2>" + message.payloadString + "°C</h2>";
        }

        var date = new Date;
        var minutes = date.getMinutes();

        console.log(minutes);
        if (minutes % <?php echo $time_save_DHT11 ?> == 0 && minutes != minutes_start && status_DHT11 != 0) {


            minutes_start = minutes;

            console.log("-----------------------");
            console.log(minutes_start);
            console.log(message.payloadString);
            console.log("S101");
            console.log(<?php echo $No_sen; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_DHT11; ?>);
            let code = "S101";
            let no_location = <?php echo $No_sen; ?>;
            let username = '<?php echo $username_ses; ?>';

            console.log(no_location);
            console.log(username);
            console.log(status);
            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status_DHT11 + "",
            });
        }

    }
    /////////////////////////////////////////////////////////////


    function onConnectionLost2(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived2(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)


        if (message.payloadString > <?php echo  $val1_SOIL; ?> && <?php echo $status_SOIL ?> != 0) {
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/2/2',

            });

            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 2 + "/" + message.payloadString,
            });

            if (<?php echo $status_SOIL ?> == 1) {
                //SOIL Notify
                <?php
                $messsge_php = "﹏ แจ้งเตือนความผิดปกติ  เซ็นเซอร์ความชิ้นในดิน  ﹏ ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location[0] . " ค่าที่กำหนดไว้ต้องไม่เกิน " . $val1_SOIL . "% [[ ค่าปัจจุบัน ";
                ?>
                if (line_SOIL == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'http://localhost/project/process_notify_line.php?unit=%&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                        cache: false,
                    });
                    line_SOIL = false;
                }

                document.getElementById('status2').innerHTML = "<h1 style='color:red'>ผิดปกติ</h1>";
            }
            status_SOIL = 2;
        } else if (message.payloadString >= 0 && <?php echo $status_SOIL ?> != 0) {
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/2/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 2 + "/" + message.payloadString,
            });
            if (<?php echo $status_SOIL ?> == 1) {
                line_SOIL = true;
                document.getElementById('status2').innerHTML = "<h1 style='color:green'>ปกติ</h1>";
            }
            status_SOIL = 1;
        }
        if (<?php echo $status_SOIL ?> == 1) {
            document.getElementById('TEST/MQTT_SOIL').innerHTML = "<h2>" + message.payloadString + "%</h2>";
        }

        var date_soil = new Date;
        var minutes_soil = date_soil.getMinutes();

        console.log(minutes_soil);
        if (minutes_soil % <?php echo $time_save_SOIL ?> == 0 && minutes_soil != minutes_start_soil && status_SOIL != 0) {
            minutes_start_soil = minutes_soil;

            console.log("-----------------------");
            console.log(minutes_start_soil);
            console.log(message.payloadString);
            console.log("S102");
            console.log(<?php echo $No_sen; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_SLOI; ?>);
            let code = "S102";
            let no_location = <?php echo $No_sen; ?>;
            let username = '<?php echo $username_ses; ?>';

            console.log(no_location);
            console.log(username);
            console.log(status);
            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status_SOIL + "",
            });
        }

    }
    ///////////////////////////////////////////////////////////


    function onConnectionLost3(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived3(message) {
        console.log("onMessageArrived:" + message.payloadString);

        if (message.payloadString > <?php echo $val1_WATER; ?> && <?php echo  $status_WATER; ?> != 0) {
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/3/2',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 3 + "/" + message.payloadString,
            });
            if (<?php echo $status_WATER ?> == 1) {
                //WATER Notify
                <?php
                $messsge_php = "▒  แจ้งเตือนความผิดปกติ เซ็นเซอร์ระดับน้ำ ▒ ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location[0] . " ค่าที่กำหนดไว้ต้องไม่เกิน " . $val1_WATER . "% [[ ค่าปัจจุบัน ";
                ?>
                if (line_WATER == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'http://localhost/project/process_notify_line.php?unit=%&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                        cache: false,
                    });
                    line_WATER = false;
                }
                document.getElementById('status3').innerHTML = "<h1 style='color:red'>ผิดปกติ</h1>";
                status_WATER = 2;
            }

        } else if (message.payloadString >= 0 && <?php echo  $status_WATER; ?> != 0) {
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/3/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 3 + "/" + message.payloadString,
            });
            if (<?php echo $status_WATER ?> == 1) {
                line_WATER = true;
                document.getElementById('status3').innerHTML = "<h1 style='color:green'>ปกติ</h1>";
                status_WATER = 1;
            }
        }
        if (<?php echo $status_WATER ?> == 1) {
            document.getElementById('TEST/MQTT_WATER').innerHTML = "<h2>" + message.payloadString + "%</h2>";
        }
        var date_WATER = new Date;
        var minutes_WATER = date_WATER.getMinutes();

        console.log(minutes_WATER);
        if (minutes_WATER % <?php echo $time_save_WATER ?> == 0 && minutes_WATER != minutes_start_WATER && status_WATER != 0) {
            minutes_start_WATER = minutes_WATER;
            console.log("-----------------------");
            console.log(minutes_start_WATER);
            console.log(message.payloadString);
            console.log("S103");
            console.log(<?php echo $No_sen; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_WATER; ?>);
            let code = "S103";
            let no_location = <?php echo $No_sen; ?>;
            let username = '<?php echo $username_ses; ?>';

            console.log(no_location);
            console.log(username);
            console.log(status);
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
        console.log(message.payloadString);

        if (message.payloadString > <?php echo $val1_RAIN; ?> && <?php echo $status_RAIN; ?> != 0) {

           
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/4/2',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 4 + "/" + message.payloadString,
            });
            if (<?php echo $status_RAIN ?> == 1) {
                //RAIN Notify
                <?php
                $messsge_php = "☂ แจ้งเตือนความผิดปกติ  เซ็นเซอร์ปริมาณน้ำฝน ☂ ติดตั้งที่ " . $place_use[0] . " บริเวณ " . $name_location[0] . " ค่าที่กำหนดไว้ต้องไม่เกิน " . $val1_RAIN . "% [[ ค่าปัจจุบัน ";
                ?>
                if (line_RAIN == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'http://localhost/project/process_notify_line.php?unit=%&val=' + message.payloadString + '&message=<?php echo $messsge_php; ?>&Uid=<?php echo $line[0] ?>',
                        cache: false,
                    });
                    line_RAIN = false;
                }
                document.getElementById('status4').innerHTML = "<h1 style='color:red'>ผิดปกติ</h1>";
                status_RAIN = 2;
            }

        } else if (message.payloadString >= 0 && <?php echo $status_RAIN; ?> != 0) {
            $.ajax({
                dataType: "json",
                url: 'http://localhost:3000/users/4/1',
            });
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/update_value/" + 4 + "/" + message.payloadString,
            });
            if (<?php echo $status_RAIN ?> == 1) {
                document.getElementById('status4').innerHTML = "<h1 style='color:green'>ปกติ</h1>";
                status_RAIN = 1;
            }
        }
        if (<?php echo $status_RAIN ?> == 1) {
            document.getElementById('TEST/MQTT_RAIN').innerHTML = "<h2>" + message.payloadString + "%</h2>";
        }
        var date_RAIN = new Date;
        var minutes_RAIN = date_RAIN.getMinutes();

        console.log(minutes_RAIN);
        if (minutes_RAIN % <?php echo $time_save_RAIN ?> == 0 && minutes_RAIN != minutes_start_RAIN && status_RAIN != 0) {
            minutes_start_RAIN = minutes_RAIN;

            console.log("-----------------------");
            console.log(minutes_start_RAIN);
            console.log(message.payloadString);
            console.log("S104");
            console.log(<?php echo $No_sen; ?>);
            console.log('<?php echo $username_ses; ?>');
            console.log(<?php echo $status_RAIN; ?>);
            let code = "S104";
            let no_location = <?php echo $No_sen; ?>;
            let username = '<?php echo $username_ses; ?>';

            console.log(no_location);
            console.log(username);
            console.log(status_RAIN);
            console.log("-----------------------");
            $.ajax({
                dataType: "json",
                url: "http://localhost:3000/report/" + message.payloadString + "/" + code + "/" + no_location + "/" + username + "/" + status_RAIN + "",
            });
        }

        if (<?php echo $status_RAIN ?> == 1) {
            document.getElementById('TEST/MQTT_RAIN').innerHTML = "<h2>" + message.payloadString + "%</h2>";
        }

    }

   




    //sound 
</script>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name_location[0] ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/home-run.png" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;500&display=swap" rel="stylesheet">

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
                        echo "  <li><a href='report.php'>รายงาน</a></li>";
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
        <div style="background-color:#181818" class="jumbotron text-center">
            <br><br>
            <br><br>
            <br><br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-5">
                        <p><?php include("icon_SVG.php") ?></p>
                        <h1 style="color:#fff"><?php echo $name_location[0]; ?> </h1>
                        <p>อุปกรณ์ทั้งหมดที่ทำการเพิ่มแล้ว! </p>
                        <a class="btn btn-primary" data-toggle="modal" data-target="#modalLoginAvatar_code" href="">เพิ่มอุปกรณ์ด้วยรหัส <img src="./images/smart-key.png" alt="" height="20px" width="20px"></a> - <a class="btn btn-primary" data-toggle="modal" data-target="#modalLoginAvatar" href="">เพิ่มอุปกรณ์(สแกนQR-Code) <img src="./images/qr-code.png" alt="" height="20px" width="20px"></a>
                        <?php
                        if ($let[0] == 0) {
                            echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtg-A7QGCqUpaDDHD4ptDhzp2GLvPj-BU&callback=initMap">
                </script>';
                            echo ' <br><br><a class="btn btn-primary"  data-toggle="modal" data-target=".bd-example-modal-lg" href="">เพิ่มพิกัด <img src="./images/home-run.png" alt="" height="20px" width="20px"></a>
                    <br><i><label style="color:red">คุณยังไม่ได้เพิ่มตำแหน่ง.</laber></i>';
                        } else {
                            echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtg-A7QGCqUpaDDHD4ptDhzp2GLvPj-BU&callback=initMap_show">
                </script>';
                            echo '<br><br><a id="delete_map"  data-toggle="modal" data-target=".bd-example-modal-lg" href="">ลบเพื่อกำหนดพิกัดใหม่ <img src="./images/delete.png" alt="" height="20px" width="20px"></a>
                           ';
                        }
                        ?>
                    </div>
                    <div class="col-sm-7">
                        <?php
                        if ($let[0] != 0) {
                            echo '<center><div id="maps"></div><br>
                        </center> ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <center>
            <h1 style="color:#fff">การจัดการเซ็นเซอร์</h1>
            <hr>
        </center>
        <div class="container">
            <div class="row text">
                <div class="l"> <button>ลบ</button></div>

                <?php
                if ($No_sensor) {
                    for ($i = 0; $i < count($No_sensor); $i++) {

                      
                        echo '<div  class="col-sm-3 sensor del_sen' . $i . ' zoom" id="del_sens' . $i . '"">
             <h1>' . $name_sen[$i] . ' <img  class="trigger-btn" href="#myModal" data-toggle="modal" id="del_pic' . $i . '" src="./images/delete_sen.png" alt="" eight="25px" width="25px" ></h1>
             <p class="deteil"></p>
             <p> <img src="./images/' . $img[$i] . '.png" alt="" eight="100px" width="100px"></p>';
                        if ($on_off[$i] == 0 and $status[$i] == 0 and $set_val1 != null) {
                            echo '<h2 style="color:#F4D03F">สถานะ</h3><div id="status' . $No_sensor[$i] . '">-</div>
                            <center><label id="' . $topic[$i] . '"><span><h2><b>อุปกรณ์ถูกปิดอยู่</b></h2></span></label></center>';
                        } else if ($on_off[$i] == 1 && $name_sen[$i] != 'ความเอียงแบบ 3 แกน') {
                            echo '<h3 style="color:#FF5500">สถานะ</h3><div id="status' . $No_sensor[$i] . '">-</div>
                             <center><div class="blink_me"><label id="' . $topic[$i] . '"><span><h2><b>รอการกำหนดค่า</b></h2></span></label></div></center>
                             ';
                        }

                       
                        if($name_sen[$i] == 'ความโน้มเอียง'){
                            if ($on_off[$i] == 1){
                                echo '
                                <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                    <h3 style="color:#FF5500">สถานะ X</h3><div id="status' . $No_sensor[$i] . '">-</div>                                    </div>
                                    <div class="col-sm">
                                    <h3 style="color:#FF5500">สถานะ Y</h3><div id="status' . $topic2[$i] . '">-</div>
                                    </div>
                                </div>
                                
                             <center>
                             <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="blink_me"> <label id="' . $topic[$i] . '"><span><h2><b>รอการกำหนดค่า X</b></h2></span></label></div>
                                    </div>
                                    <div class="col-sm">
                                    <div class="blink_me"> <label id="' . $topic2[$i] . '"><span><h2><b>รอการกำหนดค่า Y</b></h2></span></label></div>
                                   
                                    </div>
                                </div>
                              
                             </center>
                             ';
                            }
                        }
                        // 
                        echo  '<center>
              <br>
              ปิด - เปิด<label class="switch">
              <input type="checkbox" id="togBtn' . $i . '" name="active" >
              <div class="slider round">
              </div>
            </label><br>
            <button class="button_detail" id="btn_set' . $i . '"><span>ตั้งค่าอุปกรณ์</span></button>
            </center>
            </b>
      </div></center>';
                        echo ' <script>
      $("#del_pic' . $i . '").hide();
      $(".del_sen' . $i . '").mouseout(function(){
        $("#del_pic' . $i . '").hide();
    });
      $(".del_sen' . $i . '").mouseover(function(){
        $("#del_pic' . $i . '").show();
    });

    if(' . $on_off[$i] . '==0){
        var str = document.getElementById("togBtn' . $i . '").checked = false;
        
      console.log(str);  
      }else {
          var str = document.getElementById("togBtn' . $i . '").checked = true;
      console.log(str);
      }
      $("#togBtn' . $i . '").click(function(){
        var status = document.getElementById("togBtn' . $i . '").checked;
        window.location.assign("http://localhost/project/process_on_off_sensor.php?status="+status+"&no_location=' . $No[0] . '&no_sensor=' . $No_sensor[$i] . '")       
     });
     $("#btn_set' . $i . '").click(function(){
        
        window.location.assign("http://localhost/project/setting_sensor.php?no_sensor=' . $No_sensor[$i] . '")       

     });
     </script>';
                        echo '<script> 


                    $("#del_pic' . $i . '").click(function(){
                        $("#conf").click(function() {
                            window.location.assign("http://localhost/project/process_update_one_sensor.php?No_lo=' . $No[0] . '&No_sensor=' . $No_sensor[$i] . '");
       
                        });
       
           
    });</script>';
                    }
                }
                ?>
            </div>
        </div>
        <br> <label for="code" id='code'></label>

        <!-- <div class="cancel">
    <img  src="./images/cancel.png" alt="" >
                </div> -->
        <div style="padding-top:100px;" class="modal fade" id="modalLoginAvatar_code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
                <div style="height:100px ;border-radius: 10px;" class="modal-content">
                    <div style="font-size:20px" class="modal-header">
                        โปรดใส่รหัส !
                    </div>
                    <form action="process_AddInput_location.php" method="post">
                        <input style="height:30px;font-size:15px;;border-radius: 10px;" name="code_input" type="password" placeholder="ใส่รหัสอุปกรณ์">
                        <input name='No_location' type="number" value=<?php echo $No[0]; ?> hidden>
                        <button style="height:30px;border-radius: 10px;" type="submit">ยืนยัน</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Show Map-->
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
                                window.location.assign('http://localhost/project/process_update_map.php?let_value=' + let_value + '&acc="add"&lng_value=' + lng_value + '&No_location=<?php echo $No[0]; ?>');
                            });

                            $("#delete_map").click(function() {
                                window.location.assign('http://localhost/project/process_update_map.php?acc="set_map"&No_location_del=<?php echo $No[0]; ?>');

                            });
                        </script>

    </section>

    <!-- Delete_model -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">

                    <h4 class="modal-title w-100">คุณแน่ใจว่าจะลบ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" id='conf' class="btn btn-danger ">ลบ</button>
                </div>
            </div>
        </div>
    </div>


    <div style="padding-top:80px; " class="modal fade" id="modalLoginAvatar_line" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

            <div class="modal-content" style="border-radius: 10px;">
                <div style="padding-left:17%" class="modal-header">
                    <center><img src="./images/Qrcode_Linebot.png" height="220px" width="100%" alt="avatar" class="img-responsive">
                        <p style="color:gray">@137nmroa  </p>
                    </center>
                </div>
                <form action="add_line.php" method="POST">
                    <div class="modal-body text-center mb-1">
                        <h1 class="mt-1 mb-2">LINE</h1>
                        <?php
                        if ($line[0] == null) {
                            echo "<h3 style='color:red'>ท่านยังไม่ได้เชื่อมต่อ</h3>";
                        } else {
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
                            <h5> หมายเหตุ : หากต้องการเปลี่ยนไลน์ หรือ เริ่มการใช้งานในการแจ้งเตือน "ดำเนินการผ่าน Application LINE " <br>
                                <hr>
                            </h5>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div style="padding-top:100px" class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    กดแล้วสแกนเลย !
                </div>
                <canvas id="mycanvas"></canvas><br>
                <button id="btnScan">สแกนตอนนี้</button>

                <script src="http://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

                <script src="dw-qrscan.js"></script>
                <script src="jsQR.js"></script>

                <script>
                    DWTQR("mycanvas");
                    $("#btnScan").click(function() {
                        dwStartScan();

                    });

                    function dwQRReader(data) {
                        // alert(data);
                        window.location.assign("http://localhost/project/process_update_sensor.php?No_location=" + <?php echo $No[0] ?> + "&code=" + data + "")
                    }
                </script>
            </div>
        </div>
    </div>



    </div>





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

        $('.navTrigger').click(function() {
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

    .zoom {
        transition: transform 0.5s;
    }

    .zoom:hover {
        -ms-transform: scale(1);
        /* IE 9 */
        -webkit-transform: scale(0.2);
        /* Safari 3-8 */
        transform: scale(1.05);
    }

    #modalLoginAvatar {
        z-index: 2048;

    }

    .welcome {
        font-size: 20px;
        color: red;
    }

    .welcome span {
        color: #fff;
    }

    .con {
        padding-top: 150px;
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

    .sensor {
        /* padding: 10px;
              border-style: ridge;
              margin: 2px;  */
        border: 0px ridge;
        padding: 7px;
        padding-top: 20px;
        border-radius: 10px;
        background-color: #F5F5F5;
        -webkit-box-shadow: 5px 5px 15px 5px #949494;
        box-shadow: 3px 3px 15px 3px #949494;
        margin: 0px;
    }

    .modal-content {
        padding: 10px;
    }

    .container {
        padding: 10px;
        text-align: center;
    }

    .sensor:hover {
        cursor: pointer;
        background-color: #28B463;
        color: #fff;

    }

    .l {
        display: none;
    }

    .text:hover+.l {
        display: block;
    }

    /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
    #map {
        height: 500px;
        width: 600px;
    }

    .col-7 {
        height: auto;
    }

    /* Optional: Makes the sample page fill the window. */
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    #floating-panel {
        position: absolute;
        top: 10px;
        left: 10%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
    }

    #maps {
        height: 100%;
        width: 100%;
    }

    html {
        height: 100%;
        margin: 0;
        padding: 0;
        text-align: center;
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

    .switch {
        position: relative;
        display: block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d9534f;
        -webkit-transition: .4s;
        -moz-transition: .4s;
        -o-transition: .4s;
        -ms-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        -moz-transition: .4s;
        -o-transition: .4s;
        -ms-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #5cb85c;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #5cb85c;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -moz-transform: translateX(26px);
        -o-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .on {
        display: none;
    }

    .on,
    .off {
        color: white;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        font-size: 10px;
        font-family: Verdana, sans-serif;
    }

    input:checked+.slider .on {
        display: block;
    }

    input:checked+.slider .off {
        display: none;
    }

    .button_detail {
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

    .button_detail span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .button_detail span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }



    .button_detail:hover span {
        padding-right: 25px;

    }

    .button_detail:hover span:after {
        opacity: 1;
        right: 0;
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

    .blink_me {
        animation: blinker 2s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>