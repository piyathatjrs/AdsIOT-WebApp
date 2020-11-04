<?php
require("./DB/config.php");
//set_start
$X_GYRO = $_POST['X_GYRO'];
$Y_GYRO = $_POST['Y_GYRO'];
$No_sensor = $_POST['No_location'];

$No_location = $_POST['No_location_sss'];



//reset_serstart
$del_start = $_POST['delete_start'];

//set_value_x & set_value_y
$val_x = $_POST['input_gyro_x'];
$val_y = $_POST['input_gyro_y'];
$val_x_Negative = $_POST['input_gyro_x_Negative'];
$val_y_Negative = $_POST['input_gyro_y_Negative'];




if(isset($val_x) && isset($val_y) && isset($val_x_Negative) && isset($val_y_Negative) ){

    $sql = "UPDATE sensor SET set_val1=$val_x  , set_val2=$val_y , set_val3 = $val_x_Negative , set_val4= $val_y_Negative   WHERE No=$No_sensor";

    if ($link->query($sql) === TRUE) {
        header('Location: http://localhost/project/setting_sensor.php?no_sensor='.$No_sensor.'');
    } else {
        echo "Error updating record: " . $link->error;
    }
    echo $val_x . " " . $val_y ;
}

if (isset($X_GYRO) && isset($Y_GYRO) && isset($No_sensor)  ) {
    $sql = "UPDATE sensor SET start_val1=$X_GYRO  , start_val2=$Y_GYRO   WHERE No=$No_sensor";

    if ($link->query($sql) === TRUE) {
        header('Location: http://localhost/project/setting_sensor.php?no_sensor='.$No_sensor.'');
    } else {
        echo "Error updating record: " . $link->error;
    }
}

if (isset($del_start)) {
    $sql = "UPDATE sensor SET start_val1=0  , start_val2=0 ,set_val1 = null , set_val2 = null ,set_val3 = null ,set_val4 = null   WHERE No=$del_start";

    if ($link->query($sql) === TRUE) {
        header('Location: http://localhost/project/setting_sensor.php?no_sensor='.$del_start.'');
    } else {
        echo "Error updating record: " . $link->error;
    }
}
