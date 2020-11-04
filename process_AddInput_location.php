<?php 
session_start();
$usernames = $_SESSION['username'];
        require("./DB/config.php");

        $No = $_POST['No_location'];
        $code_input = $_POST["code_input"];
       
        $sql = "SELECT * FROM sensor where Code='$code_input' and On_off=0 and No_location=0 ";
        $result = $link->query($sql);
      
        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
      
            $sql = "UPDATE sensor SET User_use='$usernames',No_location = $No , On_off=1 ,status=1 where Code='$code_input' ";
      
            if (mysqli_query($link, $sql)) {
                require("wait_added.php");
              
            } else {
              echo "Error updating record: " . mysqli_error($link);
            }
            mysqli_close($link);
          }
        } else {
          require("wait_Failed.php");
        }

?>