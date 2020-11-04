<?php 

require("./DB/config.php");
    $No_sensor  = $_GET["no_sensor"];
    $No_location = $_GET['no_location'];
    $Status = $_GET['status'];
    
    if($Status=='true'){
      $sql = "UPDATE sensor SET On_off=1 , status=1 WHERE No=$No_sensor";

      if ($link->query($sql) === TRUE) {
        echo "<script>
        window.setTimeout(function() {
            window.location = 'http://localhost/project/show_sensor.php?No_lo=" . $No_location . "';
          }, 2500);
        </script>";
      } else {
        echo "Error updating record: " . $link->error;
      }
      
      $link->close();
      

    }
    if($Status == 'false'){
      $sql = "UPDATE sensor SET On_off=0 , status=0 WHERE No=$No_sensor";

      if ($link->query($sql) === TRUE) {
        echo "<script>
        window.setTimeout(function() {
            window.location = 'http://localhost/project/show_sensor.php?No_lo=" . $No_location . "';
          }, 2000);
        </script>";
      } else {
        echo "Error updating record: " . $link->error;
      }
      
      $link->close();

    }


?>

<h2 style="font-family: 'Mitr', sans-serif;" class="animate">กำลังดำเนินการ...</h2>

<style>
 @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');
@keyframes load {
    0%{
        opacity: 0.08;
/*         font-size: 10px; */
/* 				font-weight: 400; */
				filter: blur(5px);
				letter-spacing: 3px;
        }
    100%{
/*         opacity: 1; */
/*         font-size: 12px; */
/* 				font-weight:600; */
/* 				filter: blur(0); */
        }
}

.animate {
	display:flex;
	justify-content: center;
	align-items: center;
	height:100%;
	margin: auto;
/* 	width: 350px; */
/* 	font-size:26px; */
	font-family: Helvetica, sans-serif, Arial;
	animation: load 1.2s infinite 0s ease-in-out;
	animation-direction: alternate;
	text-shadow: 0 0 1px white;
}
body, html{
	height: 96vh;

	color: black;
}

</style>