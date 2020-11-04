<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: http://localhost/project/Login_v16/index_login.php");
  exit;
}
require("./DB/config.php");
?>
<?php
$del = $_GET['No'];

//sql to delete a record
$sql_del = "DELETE FROM the_location WHERE No= $del ";

if ($link->query($sql_del) === TRUE) {
  echo "<script>
        window.location = 'http://localhost/project/';
     
    </script>";
} else {
  echo "Error deleting record: " . $link->error;
}

$sql = "UPDATE sensor SET 
User_use=null , 
No_location=0 ,
On_off=0 , 
set_val1=null , 
set_val2=null , 
set_val3=null ,
start_val1=0,
start_val2=0,
status=0,
save_time=2
where No_location=$del";

if ($link->query($sql) === TRUE) {
} else {
  echo "Error updating record: " . $link->error;
}


// sql to delete a record
$sql_del_maps = "DELETE FROM map where No_location = $del ";

if ($link->query($sql_del_maps) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $link->error;
}



$link->close();


?>