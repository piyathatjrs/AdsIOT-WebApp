<?php 
require("./DB/config.php");


$No_sensor = $_POST['no_sensor'];
$value = $_POST['save_time'];



$sql = "UPDATE sensor SET save_time=$value WHERE No=$No_sensor";

if ($link->query($sql) === TRUE) {
    echo "<script>
    window.location = 'http://localhost/project/setting_sensor.php?no_sensor=$No_sensor';
</script>";
} else {
  echo "Error updating record: " . $link->error;
}

$link->close();




?>