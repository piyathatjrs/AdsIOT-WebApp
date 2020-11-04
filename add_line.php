<?php 

require("./DB/config.php");
    $Uid = $_POST["uid"];
    $username = $_POST['username'];
echo $Uid." ".$username;


    $sql = "UPDATE users SET line='$Uid' WHERE username='$username'";

    if ($link->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
$link->close();



?>