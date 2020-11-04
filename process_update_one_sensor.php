<?php 
        require("./DB/config.php");
    $No_sensor = $_GET["No_sensor"];
    $No_lo = $_GET["No_lo"];
    
    $sql = "UPDATE sensor SET 
    User_use=null,
    No_location = 0 , 
    On_off=0 ,
    status=0 ,
    set_val1=null,
    set_val2=null,
    set_val3=null
    where No=$No_sensor ";

      if (mysqli_query($link, $sql)) {
        echo "<script>
        window.setTimeout(function() {
            window.location = 'http://localhost/project/show_sensor.php?No_lo=" . $No_lo . "';
          }, 1000);
        </script>";
      } else {
        echo "Error updating record: " . mysqli_error($link);
      }
      mysqli_close($link);
