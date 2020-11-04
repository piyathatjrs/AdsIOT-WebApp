<?php
require("./DB/config.php");
if(isset($_POST['locat_name'])){
$locatName=$_POST['locat_name'];
$lat=$_POST['mapsLat'];
$lng=$_POST['mapsLng'];
$mapsZoom=$_POST['mapsZoom'];
//echo $locatName;
mysqli_connect("INSERT INTO tb_mapsgoo(name_mps,lat_mps,lng_mps,zoom_mps) VALUES('$locatName','$lat','$lng','$mapsZoom')");
}
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" style="border:1px solid #CCC;background-color:#E4E4E4;">
  <tr>
    <td align="center"><strong>ชื่อสถานที่</strong></td>
    <td align="center"><strong>ละติจูด</strong></td>
    <td align="center"><strong>ลองติจูด</strong></td>
    <td align="center"><strong>ซูม</strong></td>
  </tr>
  <?php 
  $rsMapsGoo=mysqli_connect('SELECT * FROM tb_mapsgoo ORDER BY name_mps ASC');
  while($showMapsGoo=mysqli_connect($rsMapsGoo)){
  ?>
  <tr>
    <td><a href="showmaps.php?mapsId=<?=$showMapsGoo['id_mps']?>" target="_blank"><?=$showMapsGoo['name_mps']?></a></td>
    <td align="center"><?=$showMapsGoo['lat_mps']?></td>
    <td align="center"><?=$showMapsGoo['lng_mps']?></td>
    <td align="center"><?=$showMapsGoo['zoom_mps']?></td>
  </tr>
  <?php } mysqli_connect($link);?>
</table>