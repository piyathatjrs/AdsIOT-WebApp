<html>

<head>
    <title>ส่งข้อมูลเรียบร้อย</title>
</head>

<body>
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myproject";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $mail = $_POST['email'];

    $sql = "SELECT * FROM users where username = '$mail' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $numrand = (mt_rand());
            $to      = $mail;
            $subject = 'ระบบเฝ้าระวังภัย(ลืมรหัสผ่าน)';
            $message = 'รหัสใหม่ของคุณคือ  ' . $numrand;
            $headers = 'From: adsiot.system@gmail.com' . "\r\n" .
                'Reply-To: adsiot.system@gmail.com';

            mail($to, $subject, $message, $headers);
            $numrand = password_hash($numrand, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password='$numrand' WHERE username='$mail'";



            echo "<script>";
            echo "alert('ส่งข้อความเรียบร้อยแล้ว');";
            echo "window.location ='http://localhost/project/Login_v16/index_login.php'; ";
            echo "</script>";

            if ($conn->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    } else {
        echo "ไม่พบอีเมลผู้ใช้";
        echo "<script>
       window.setTimeout(function() {
           window.location = 'http://localhost/project/Forgot_password.php';
         }, 2000);
       </script>";
    }






    $conn->close();

    ?>
</body>

</html>