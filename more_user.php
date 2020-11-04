
<?php require("./DB/config.php")?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/lib/bootstrap.min.css">
  <script src="/lib/jquery-1.12.2.min.js"></script>
  <script src="/lib/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</head>

SELECT * from map mp join the_location loca 
on mp.No_location = loca.No join sensor sen 
on loca.No = sen.No_location join users us on sen.User_use = us.username; 

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
$sql = "SELECT * from users";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $id[] = $row['id'];
    $username_ac[] = $row['username'];
    $place_use[] = $row['place_use'];
 
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
echo count($id);


?>
<body>
<h2>สถานที่ ที่มีการติดตั้งอุปกรณ์</h2>
<?php
for ($i=0; $i <count($id) ; $i++) { 
    echo $username_ac[$i]." (".$place_use[$i].")<br>";
    # code...
    for ($j=0; $j <count($No) ; $j++) { 
        # code...
        if($username_ac[$i] == $username[$j] ){
          echo $name_location[$j]."<br>"; 
        for ($g=0; $g <count($No_sensor) ; $g++) { 
            # code...
            if($No[$j] == $No_location[$g]){
                echo "- ".$Name_sensor[$g]."<br>";
            }
        } 
        }
    }
    echo "-------------------------<br>";   
}


?>
</body>
</html>
<style>
    .space{
        padding:10px;
    }
</style>