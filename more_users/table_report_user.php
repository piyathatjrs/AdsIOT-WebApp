
<?php
require("../DB/config.php");
$username_ses = $_GET['username'];
$code_report = $_GET['code'];

$sql = "select * from sensor where Code ='$code_report' ";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $name = $row['Name_sensor'];
}

$sql = "select * from users where username ='$username_ses' ";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
   $place_use = $row['place_use'];
}


// $code_report = 'S101';
// $username_ses = 'charonesak_P@silpakorn.edu';
echo "<center><h1>รายงานของ</h1>";
echo "<h3>".$username_ses."</h3>";
echo "<h3>".$name."</h3>";
echo "<h4>สถานที่ : ".$place_use."</h4>";
echo "<a href='http://localhost/project/more_users/' class='btn'>กลับไปหน้าหลัก</a></center>";
$sql = "select lo.name_location , sen.Name_sensor , re.status ,re.value1 ,re.date from report_all re join sensor sen on re.code = sen.Code join the_location lo on sen.No_location = lo.No  where re.code ='".$code_report."' and re.username = '".$username_ses."'
";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $Nos[] = $row['No'];
    $value1[] = $row['value1'];
    $date[] = $row['date'];
    $code[] = $row['Name_sensor'];
    $location[] = $row['name_location'];
    $status[] = $row['status'];
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script> 
<script src="html2pdf.bundle.min.js"></script>
<script>
         $(document).ready(function() {
           $('#example').DataTable({
             "pageLength": 10, //จำนวนข้อมูลที่ให้แสดง ต่อ 1 หน้า
             "searching": true,//เปิด=true ปิด=false ช่องค้นหาครอบจักรวาล
             "lengthChange": true,//เปิด=true ปิด=false ช่องปรับขนาดการแสดงผล
           });
         });

         function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดาวน์โหลดรายงาน</title>
    <link rel="shortcut icon" type="image/x-icon" href="./images/save.png" />
    
</head>
<body style="font-family: 'Mitr', sans-serif;">
<div class="container-fluid table">
  <div class="row">
    <div class="col-sm">
    <div style="padding:0px 10px 30px 30px" id="invoice">
 
<table id="example" class="table table-striped table-bordered tblData">
         <thead>
            <tr>
                <th>ลำดับ</th>
               <th>ค่าที่ได้</th>
               <th>วันที่บันทึก</th>
               <th>ชื่อเซ็นเซอร์</th>
               <th>บริเวณ / สถานที่</th>
               <th>สถานะ</th>
            </tr>
         </thead>
         <tbody>
                <?php 
                if($Nos){
                      for ($i=0; $i <count($Nos) ; $i++) { 
                        if($code[$i] === 'อุณภูมิในอากาศ'){
                            $type = "°C";
                        }else 
                        if($code[$i] === 'ความชื้นในดิน'){
                            $type = "%";
                        }else {
                            $type = "%";
                        }
                   echo " <tr><td>".($i+1)."</td>";
                   echo "<td>".$value1[$i]."$type"."</td>";
                   echo "<td>".$date[$i]."</td>";
                   echo "<td>".$code[$i]."</td>";
                   echo "<td>".$location[$i]."</td>";
                  //  echo "<td>".$status[$i]."</td>";
                   if($status[$i] == 1){
                    echo '<td><span style="color:green">ปกติ</span></td>';
                   }else if($status[$i]==2 ) {
                    echo '<td><span style="color:red">ผิดปกติ</span></td>';
                   }
                }
                }
                ?>
         </tbody>
      </table>
              </div>
              <!-- <button onclick="exportTableToExcel('example', 'members-data')">Export Table Data To Excel File</button>           -->
    </div>   
  </div>
</div>
    <div class="table">
    </div>
</body>
</html>
<style>

@import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
@import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');  
    .table{
        padding:50px 30px 30px 30px;
    }
</style>


