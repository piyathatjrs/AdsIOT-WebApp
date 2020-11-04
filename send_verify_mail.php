

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

 <?php
 $email = "piyathatjrs@gmail.com";
   $strTo = $email;
   $strSubject = "ยืนยันการเป็นสมาชิก ระบบเฝ้าระวังภัยโบราณสถานแบบปรับตัวได้ด้วยเทคโนโลยีอินเตอร์เน็ตของสรรพสิ่ง
   An Adaptive Disaster Surveillance System of Archaeological Site with Internet of Things";
   $strHeader = "Content-type: text/html; charset=UTF-8\n"; 
   $strHeader .= "From: adsiot.system@gmail.com";
   $strMessage = "ยินดีต้อนรับสมาชิก E-mail : ".$email."<br>";
   $strMessage .= "กรุณาทำยืนยันอีเมลล์ เพื่อให้การสมัครสมาชิกของท่านเสร็จสมบูรณ์ โดยกดที่ลิ้งข้างล่างนี้";
   $strMessage .= "<a class='btn'  style='color:red;font-size:20px' href=https://google.com>"."<br>"."<br>"; 
   $strMessage .= "กดเพื่อยืนยันอีเมลล์"."</a>"."<br>"."<br>";
  
   $flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
</html>
