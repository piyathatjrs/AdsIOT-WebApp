
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

$No = $_GET['No_location'];
$usernames = $_SESSION['username'];
$code = $_GET['code'];

echo $No;
echo $usernames;
echo $code;

if ($code) {
  $sql = "SELECT * FROM sensor where Code='$code' and On_off=0";
  $result = $link->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

      $sql = "UPDATE sensor SET User_use='$usernames',No_location = $No , On_off=1 ,status=1 where Code='$code' ";

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
}else {
  

}






//   ::: update :::


?>
