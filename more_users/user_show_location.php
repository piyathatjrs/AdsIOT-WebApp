<?php
require("../DB/config.php");
?>
<?php
$place_use = $_GET["place_use"];

?>
<?php
$sql = "SELECT * from sensor join the_location on sensor.No_location = the_location.No  where User_use = '$place_use'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
  $No_sensor[] = $row['No'];
  $No_location[] = $row['No_location'];
  $Name_sensor[] = $row['Name_sensor'];
  $name_location[] = $row['name_location'];
  $img[] = $row['img'];
  $detail[] = $row['Detail'];
  $topic[] = $row['topic'];
  $value_Realtime[] = $row['value_Realtime'];
  $code[] = $row['Code'];
  $status[] = $row['status'];
  $val1[] = $row['set_val1'];
}

$sql = "SELECT * from users where username= '$place_use'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
  $id[] = $row['id'];
  $username_ac[] = $row['username'];
  $place_use_ac[] = $row['place_use'];
  $firstname[] = $row['firstname'];
  $lastname[] = $row['lastname'];
  $description[] = $row['line_id'];
}
$sql_map = "SELECT * FROM map where username = '$place_use'";
$result_map = mysqli_query($link, $sql_map);
while ($row_map = mysqli_fetch_array($result_map)) {
  $No_map[] = $row_map['No'];
  $let[] = $row_map['let'];
  $lng[] = $row_map['lng'];
}
echo "<div hidden> " . $let[0] . "</div>";


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $place_use_ac[0] ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="place_user.png" />

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">
</head>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtg-A7QGCqUpaDDHD4ptDhzp2GLvPj-BU&callback=initMap_show">
</script>
<script>
  function table_report() {
    window.open("http://localhost/project/table_report.php");

  }


  function initMap_show() {
    var mapOptions = {

      center: {

        lat: <?php echo $let[0]; ?>,
        lng: <?php echo $lng[0]; ?>
      },
      zoom: 18,
    }
    var maps = new google.maps.Map(document.getElementById("maps"), mapOptions);

    var marker, i, info;

    for (i = 0; i < locations.length; i++) {

      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: maps,
        title: locations[i][0]
      });

      info = new google.maps.InfoWindow();

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          info.setContent(locations[i][0]);
          info.open(maps, marker);
        }
      })(marker, i));
    }
  }
</script>


<body style="font-family: 'Mitr', sans-serif;">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="http://localhost/project/more_users/"><img src="../images/title.png" alt="" height="55px"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">

            <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">

          </li>
          <li class="nav-item">
            <a href="http://localhost/project/more_users/">หน้าแรก</a>
          </li>
          <li class="nav-item">

          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Page Content -->
  <div class="container">

    <!-- Heading Row -->
    <div class="row align-items-center my-5">
      <div class="col-lg-7">

        <div id="maps"></div>

      </div>
      <!-- /.col-lg-8 -->
      <div class="col-lg-5">
        <h1 class="font-weight-light"><?php echo $place_use_ac[0] ?></h1>
        <p><?php echo $description[0]; ?></p>

      </div>
      <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->

    <!-- Call to Action Well -->
    <div class="card text-white bg-secondary my-5 py-4 text-center">
      <div class="card-body">
        <p class="text-white m-0">อุปกรณ์ที่ทำการติดตั้ง ณ <u><b><?php echo $place_use_ac[0] ?></b></u> ทั้งหมด</p>
      </div>
    </div>

    <!-- Content Row -->
    <div class="row">
      <link rel="shortcut icon" type="image/x-icon" href="show_user.png" />
      <?php
      $type = '';
      if ($No_sensor != null) {
        for ($i = 0; $i < count($No_sensor); $i++) {
          if ($Name_sensor[$i] === 'อุณภูมิในอากาศ') {
            $type = "°C";
          } else {
            $type = "%";
          }
          echo ' <div class="col-md-4 mb-5">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="card-title">' . $name_location[$i] . '</h2>
            
            <h6 style="color:#DC7633 ">' . $Name_sensor[$i] . '</h6>
            <p class="card-text">
            <table>
            <tr>
            <td> <img src="../images/' . $img[$i] . '.png" alt="" width="100px" height="100px"></td>';
          if ($val1[$i] == null) {
            echo '<td> <div style="padding-left:50px;color:red"><label id="' . $topic[$i] . '"><h5>รอกำหนดค่า</h5></label></div></td>';
          } else 
           if ($status[$i] != 0) {
            echo '<td> <div class="blink_me" style="padding-left:50px"><label id="' . $topic[$i] . '"><span><h4><b>' . $value_Realtime[$i] . ' ' . $type . '</b></h4></span></label></div></td>';
          } else if ($status[$i] == 0) {
            echo '<td> <div style="padding-left:50px;color:red"><label id="' . $topic[$i] . '"><h5>ปิดการใช้งาน</h5></label></div></td>';
          }


          echo '</tr>
            </table>
            </p>
           
          </div>
          <div class="card-footer">
             
            <a href="http://localhost/project/more_users/table_report_user.php?code=' . $code[$i] . '&username=' . $username_ac[0] . '" class="btn btn-primary btn-sm">ดูข้อมูลย้อนหลัง</a><br>
            <small>หมายเหตุ : ช่วงเวลาการเก็บข้อมูลขึ้นอยู่กับ <b><u>ผู้ดูแลเป็นผู้กำหนดกำหนดขึ้นมาเท่านั้น.</u></b></small>
          </div>
        </div>
      </div>
   ';
          // echo $Name_sensor[$i]."<br>";
          # code...
        }
      }
      ?>
      <!-- /.col-md-4 -->

    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container-fluid">
      <p class="m-0 text-center text-white">Copyright &copy; AdsIOT.System 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<script>
  $(function(){
     var interval = 1;

     function ajaxCall(){
     		console.log('ajax called');
     }

     ajaxCall();
     setInterval(function(){
      location.reload();
     		ajaxCall();
     },10000);
  });
</script>


<style>
  @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
  @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');

  #maps {
    height: 250;
    width: 635;
    border-radius: 10px;
  }

  .blink_me {
    animation: blinker 2.5s linear infinite;
  }

  @keyframes blinker {
    50% {
      opacity: 0;
    }
  }
</style>