
<?php
require("./DB/config.php");
if ($acc = "set_map") {
    $No_location_del = $_GET['No_location_del'];
$acc = $_GET['acc'];
    echo $No_location_del;
    $sql_set = "UPDATE map SET let=0 , lng=0 WHERE No_location=$No_location_del";

    if ($link->query($sql_set) === TRUE) {
        if($No_location_del == 999999){
             echo "<script>
            window.setTimeout(function() {
                window.location = 'http://localhost/project/welcome.php';
              });
            </script>";
        }else {
            echo "<script>
            window.setTimeout(function() {
                window.location = 'http://localhost/project/show_sensor.php?No_lo=".$No_location_del."';
              });
            </script>";
        }
       
       
    } else {
       
    }
}
if ($acc = "add") {
    $let = $_GET['let_value'];
    $lng = $_GET['lng_value'];
    $No_location = $_GET['No_location'];
    $sql = "UPDATE map SET let=$let , lng=$lng WHERE No_location=$No_location";

    if ($link->query($sql) === TRUE) {
        if($No_location == 999999){
            echo "<script>
           window.setTimeout(function() {
               window.location = 'http://localhost/project/welcome.php';
             });
           </script>";
       }else {
           echo "<script>
           window.setTimeout(function() {
               window.location = 'http://localhost/project/show_sensor.php?No_lo=".$No_location."';
             });
           </script>";
       }
    }
}
$link->close();
?>