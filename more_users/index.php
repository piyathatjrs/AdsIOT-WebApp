<?php require("../DB/config.php");?>


<?php 

// $sql = "SELECT * from map mp join the_location loca 
// on mp.No_location = loca.No join sensor sen 
// on loca.No = sen.No_location join users us on sen.User_use = us.username  ";
// $result = mysqli_query($link, $sql);
// while ($row = mysqli_fetch_array($result)) {
//     $No[] = $row['No'];
//     $name_location[] = $row['name_location'];
//     $username_lo[] = $row['username'];
//     $date[] = $row['date'];
//     $sensor[] = $row['Name_sensor'];
// }
$sql = "SELECT * from users where verify =1 " ;
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $id[] = $row['id'];
    $username_ac[] = $row['username'];
    $place_use[] = $row['place_use'];
    $firstname[] = $row['firstname'];
    $lastname[] = $row['lastname'];
    $description[] = $row['line_id'];

 
}
$sql = "SELECT * from the_location";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $No[] = $row['No'];
    $username[] = $row['username'];
    $name_location[] = $row['name_location'];
 
}

$sql = "SELECT * from sensor";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $No_sensor[] = $row['No'];
    $No_location[] = $row['No_location'];
    $Name_sensor[] = $row['Name_sensor'];
 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" type="image/x-icon" href="place_user.png" />

  <title>ยินดีต้อนรับ(บุคคลทั่วไป)</title>
 

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body  style="font-family: 'Mitr', sans-serif;">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="http://localhost/project/more_users/"><img src="../images/title.png" alt="" height="55px" ></a>
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

    <div class="row">

      <div class="col-lg-3">

        <h1  style="padding-top:100px"  class="my-4" id="head">สถานที่ทั้งหมด</h1>
        <div class="list-group">

        <?php
for ($i=0; $i <count($id) ; $i++) { 
  if($firstname[$i]!= 'Admin'){
   echo '  <a href="http://localhost/project/more_users/user_show_location.php?place_use='.$username_ac[$i].'" class="list-group-item">'.$place_use[$i].'</a>';
    # code...
    // for ($j=0; $j <count($No) ; $j++) { 
    //     # code...
    //     if($username_ac[$i] == $username[$j] ){
    //       echo $name_location[$j]."<br>"; 
    //     for ($g=0; $g <count($No_sensor) ; $g++) { 
    //         # code...
    //         if($No[$j] == $No_location[$g]){
    //             echo "- ".$Name_sensor[$g]."<br>";
    //         }
    //     } 
    //     }
    // }

  }
}
?>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div style="padding-top:100px" class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="title1_user.png" alt="First slide">
            </div>
           
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">

        <?php
for ($i=0; $i <count($id) ; $i++) { 
  if($firstname[$i]!= 'Admin'){
 echo '  <div class="col-lg-4 col-md-6 mb-4 zoom">
    <div id="demo" class="card h-100">
    <div style="padding-left:500px class="row">
    <div " class="col">';
    
    require("gif.php");
    
    echo '</div>
   </div>
      <div class="card-body">
        <h4 class="card-title">
          <a href="http://localhost/project/more_users/user_show_location.php?place_use='.$username_ac[$i].'">'.$place_use[$i].'</a>
        </h4>
       
        <p  class="card-text">'.$description[$i].'</p>
      </div>
      <div  class="card-footer">
        <small  class="text-muted">ผู้ดูแล : '.$firstname[$i].' '.$lastname[$i].'</small>
      </div>
    </div>
  </div>';

  }
   
    # code...
    // for ($j=0; $j <count($No) ; $j++) { 
    //     # code...
    //     if($username_ac[$i] == $username[$j] ){
    //       echo $name_location[$j]."<br>"; 
    //     for ($g=0; $g <count($No_sensor) ; $g++) { 
    //         # code...
    //         if($No[$j] == $No_location[$g]){
    //             echo "- ".$Name_sensor[$g]."<br>";
    //         }
    //     } 
    //     }
    // }
  
}
?>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; AdsIOT.System 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<style>

@import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
@import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');
  


  #demo:hover {
-webkit-box-shadow: 0px 10px 13px -7px #000000, 34px 19px 11px 27px rgba(0,0,0,0); 
box-shadow: 0px 10px 13px -7px #000000, 34px 19px 11px 27px rgba(0,0,0,0);
background-color: #2AA7F9;
color:#fff;

}
#demo p {
	line-height:15pt;
	height:57pt;
	overflow:hidden;
}
.zoom{
  transition: transform 0.5s;
}
.zoom:hover {
  -ms-transform: scale(1); /* IE 9 */
  -webkit-transform: scale(0.2); /* Safari 3-8 */
  transform: scale(1.1); 
}

</style>
