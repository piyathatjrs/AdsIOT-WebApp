<?php
session_start();
require("./DB/config.php");
$f_name = $_POST['firs_name'];
$l_name = $_POST['last_name'];
$user = $_SESSION['username'];
$place = $_POST['place'];
$line_id = $_POST['line_id'];



$sql = "UPDATE users SET lastname='$l_name' , firstname = '$f_name' , place_use='$place' , line_id='$line_id'   WHERE username='$user'";

if ($link->query($sql) === TRUE) {
    echo "<script>
        window.location = 'http://localhost/project/profile.php';
    </script>";
} else {
  echo "Error updating record: " . $link->error;
}

$link->close();


?>