<?php 

require("./DB/config.php");

        $val1 = $_POST['in1_RAIN'];
       
        $No_sensor = $_POST['No_location'];
       
        // DHT11 
       
        $sql = "UPDATE sensor SET set_val1=$val1  where type='RAIN'";

if ($link->query($sql) === TRUE) {
  echo "Ok";
  echo "<script>
  window.location = 'http://localhost/project/setting_sensor.php?no_sensor=" . $No_sensor . "';

</script>";
} else {
  echo "Error updating record: " . $link->error;
}
            //////////////////////////////////////////////////
         
        
$link->close();



?>