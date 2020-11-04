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

$name_location = $_POST['name_location'];
$username = $_SESSION['username'];
$type = $_POST['type'];



if ($type) {
    if ($type == 'Add') {

        $sql = "INSERT INTO the_location (name_location, username)
VALUES ('$name_location', '$username')";

        if ($link->query($sql) === TRUE) {

            //         echo "<script>
            // window.setTimeout(function() {
            //     window.location = 'http://localhost/project/';
            //   }, 1000);
            // </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $link->error;
        }
        $sql_max_no = "SELECT max(No) AS max FROM the_location ";
        $result = mysqli_query($link, $sql_max_no);
        while ($row = mysqli_fetch_array($result)) {
            $No[] = $row['max'];
        }

        $sql_no_max = "INSERT INTO map (No_location, username)
        VALUES ($No[0], '$username')";

        if ($link->query($sql_no_max) === TRUE) {
        
          echo "<script>
       
            window.location = 'http://localhost/project/';
         
        </script>";
        } else {
          echo "Error: " . $sql_no_max . "<br>" . $link->error;
        }

        $link->close();
    }

    if ($type == "Del") {
    }
}else{


}
