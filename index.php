<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
    header("location: http://localhost/project/welcome.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยินดีต้อนรับ</title>
     
     <script src="script.js"></script>
        <script src="https://dribbble.com/shots/2536070-Jelly-Buttons-CSS"></script>

</head>
<body>
    <nav class="nav">
        <div class="container">
            <div class="logo">
                <img src="./images/title.png" alt="" style="width:65%">
            </div>
            <div id="mainListDiv" class="main_list">
                <ul class="navlinks">
                    <li><a href="http://localhost/project/Login_v16/index_login.php" style="font-family: 'Mitr', sans-serif;">เข้าสู่ระบบ</a></li>

                    
                    <li><a href="http://localhost/project/Login_v16/register/index.php" style="font-family: 'Mitr', sans-serif;">สมัครสมาชิก</a></li>

                </ul>
            </div>
            <span class="navTrigger">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </div>
    </nav>
    <section class="home">
        <form class="wel">
    <a class="wording">ยินดีต้อนรับ!</a><br>
    <a class="wording" style="font-size:180%">ระบบเฝ้าระวังภัยโบราณสถานแบบปรับตัวได้ด้วยเทคโนโลยีอินเตอร์เน็ตของสรรพสิ่ง<a><br>
    <a class="wording" style="font-size:150%">เข้าสู่ระบบเพื่อเริ่มต้นการใช้งาน<a><br><br>
    <a  href="http://localhost/project/Login_v16/index_login.php" title="Button fade blue/green" class="button btnFade btnBlueGreen" style="font-size:200%">เข้าสู่ระบบ</a></form>
    </section>
    <div style="height: auto">
        <!-- just to make scrolling effect possible --> <br>
            <br>
			<h2 class="myH2" style="font-family: 'Mitr', sans-serif;">เกี่ยวกับระบบ</h2>
			<p class="myP" style="font-family: 'Mitr', sans-serif;">ชื่อระบบ : ระบบเฝ้าระวังภัยโบราณสถานแบบปรับตัวได้ด้วยเทคโนโลยีอินเตอร์เน็ตของสรรพสิ่ง</p>
			<p class="myP" style="font-size:15px" style="font-family: 'Mitr', sans-serif;">System name : An Adaptive Disaster Surveillance System of Archaeological Site with Internet of Things</a></p>
            <br>
				<p class="myP" style="font-family: 'Mitr', sans-serif;">
                โบราณสถาน คืออาคารหรือสิ่งก่อสร้างซึ่งเกิดจากการสร้างจากฝีมือมนุษย์อันมีอายุเก่าแก่ และทรงคุณค่า                  
                 ทางด้าน ศิลปะ ประวัติศาสตร์ หรือโบราณคดี รวมไปถึงเนินดิน สถานที่พบร่องรอยการทำกิจกรรมของมนุษย์ โบราณสถาน         
                  จึงนับว่าเป็นสถานที่ที่มีความสำคัญอย่างมากทั้งในด้าน วัฒนธรรม การศึกษา ศิลปะ อีกทั้งยังเป็นสถานที่ยึดเหนี่ยวจิตใจ      
                     ของหลาย ๆ คน โบราณสถานจึงนับว่าเป็นแหล่งศึกษาทางประวัติศาสตร์ได้อย่างดีเยี่ยม เป็นเส้นทางเชื่อมต่อระหว่างอดีต 
                     สู่ปัจจุบัน ซึ่งอาจมีผลต่อในอนาคต จึงทำให้ปัจจุบัน การศึกษาเกี่ยวกับประวัติศาสตร์ ได้รับความนิยมมากขึ้น 
    เนื่องจากโบราณสถานหลาย ๆ แห่ง มีอายุขัยที่มากขึ้นตามกาลเวลา จึงมีความจำเป็นที่จะต้องดูและรักษาโบราณสถานให้ทั่วถึงและทันกาล
     ปัจจัยที่จะทำให้โบราณสถานชำรุดทรุดโทรมอาจมีสาเหตุมาจากหลายปัจจัย เช่น ชำรุดจากฝีมือมนุษย์  การสึกกร่อนตามธรรมชาติ รวมไปถึงภัยพิบัติ
     ที่สามารถสร้างความเสียหายให้กับโบราณสถานได้ ซึ่งหากปล่อยให้โบราณสถานชำรุดทรุดโทรมเป็นเวลานาน อาจส่งผลกระทบอย่างมหาศาลตามมาภายหลังได้
    จึงเกิดเป็นแนวคิดในการพัฒนาระบบเฝ้าระวังภัยโบราณสถานแบบปรับตัวได้ด้วยเทคโนโลยีอินเตอร์เน็ตของสรรพสิ่ง  ซึ่งพัฒนาขึ้นมาเพื่อเฝ้าระวังโบราณสถานจากภัยต่าง ๆ 
    เช่น ภัยพิบัติทางธรรมชาติ และสามารถแจ้งเตือนได้อย่างทันท่วงทีทำให้ผู้ที่มีส่วนเกี่ยวข้องเข้ามาดูแลและฟื้นฟูโบราณสถานตามเห็นสมควร ซึ่งจะช่วยให้ดูแลรักษาโบราณสถานได้
    อย่างมีประสิทธิภาพยิ่งขึ้น
			</p>
    </div>
<!-- Jquery needed -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
<!-- Function used to shrink nav bar removing paddings and adding black background -->
    <script>
        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
            }
        });
    </script>
</body>
</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,500,700');
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Raleway:ital,wght@1,531&display=swap" rel="stylesheet');

    .home {
    box-sizing: border-box;
    font-family: 'Mitr', sans-serif;
    }

  
        .wording {
        font-size: 50px;
        padding-top:15%;
        color:#fff;
        width:30%;
        height:200px;
        text-shadow: 0px 0px 3px rgba(0,0,0,0.55);
    }
.wel{
    margin-left:10%;
    padding-top:15%;
}
.button{
height:20%;
width:10%;
}
/*******************************************************************/


      p {
        margin-bottom: 0.5em;
      }
      a,
      a:visited {
        text-decoration: none;
        color: #00AE68;
      }
      .clear {
        clear: both;
      }

      

     
      .pageSubTitle {
        margin-bottom: 0.5em;
        font-size: 10%;
        font-weight: 700;
        line-height: 1em;
        color: #222;
      }
      .articleTitle {
        font-size: 10%;
        font-weight: 700;
        line-height: 1em;
        color: #222;
      }
      .wrapper {
        width: 600px;
      }

      

      
      a.button {
        display: block;
        float: left;
        width: 20%;
        padding: 0;
        margin: 10px 20px 10px 0;
        font-weight: 1000;
        text-align: center;
        line-height: 50px;
        color: #FFF;
        border-radius: 5px;
        transition: all 0.2s ;
        -webkit-box-shadow: 0px 0px 8px -5px #000000; 
box-shadow: 0px 0px 8px -5px #000000;
      }
      .btnBlueGreen {
         /* For browsers that do not support gradients */
  background: -webkit-linear-gradient(left top, #FF4E50, #F9D423); /* For Safari 5.1 to 6.0 */
  background: -o-linear-gradient(bottom right,#FF4E50, #F9D423); /* For Opera 11.1 to 12.0 */
  background: -moz-linear-gradient(bottom right,#FF4E50, #F9D423); /* For Firefox 3.6 to 15 */
  background: linear-gradient(to bottom right, #FF4E50, #F9D423); /* Standard syntax */
      }
      .btnLightBlue {
        background: #5DC8CD;
      }
      .btnOrange {
        background: #FFAA40;
      }
      .btnPurple {
        background: #A74982;
      }
      /* FADE */
      .btnFade.btnBlueGreen:hover {
        background: #DBD5A4;
        color: #000;
      }
      .btnFade.btnLightBlue:hover {
        background: #01939A;
      }
      .btnFade.btnOrange:hover {
        background: #FF8E00;
      }
      .btnFade.btnPurple:hover {
        background: #6D184B;
      }
      /* 3D */
      .btnBlueGreen.btnPush {
        box-shadow: 0px 5px 0px 0px #007144;
      }
      .btnLightBlue.btnPush {
        box-shadow: 0px 5px 0px 0px #1E8185;
      }
      .btnOrange.btnPush {
        box-shadow: 0px 5px 0px 0px #A66615;
      }
      .btnPurple.btnPush {
        box-shadow: 0px 5px 0px 0px #6D184B;
      }
      .btnPush:hover {
        margin-top: 15px;
        margin-bottom: 5px;
      }
      .btnBlueGreen.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #007144;
      }
      .btnLightBlue.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #1E8185;
      }
      .btnOrange.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #A66615;
      }
      .btnPurple.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #6D184B;
      }
      /* BORDER */
      .btnBlueGreen.btnBorder {
        box-shadow: 0px 0px 0px 0px #21825B;
      }
      .btnBlueGreen.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #21825B;
      }
      .btnLightBlue.btnBorder {
        box-shadow: 0px 0px 0px 0px #01939A;
      }
      .btnLightBlue.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #01939A;
      }
      .btnOrange.btnBorder {
        box-shadow: 0px 0px 0px 0px #A66615;
      }
      .btnOrange.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #A66615;
      }
      .btnPurple.btnBorder {
        box-shadow: 0px 0px 0px 0px #6D184B;
      }
      .btnPurple.btnBorder:hover {
        box-shadow: 0px 0px 0px 5px #6D184B;
      }
      /* FLOAT */
      .btnFloat {
        background: none;
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.5);
      }
      .btnFloat:before {
        content: 'Float';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 120px;
        height: 50px;
        border-radius: 5px;
        transition: all 0.2s ;
      }
      .btnBlueGreen.btnFloat:before {
        background: #00AE68;
      }
      .btnLightBlue.btnFloat:before {
        background: #5DC8CD;
      }
      .btnOrange.btnFloat:before {
        background: #FFAA40;
      }
      .btnPurple.btnFloat:before {
        background: #8D336A;
      }

      
      .btnFloat:before {
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.4);
      }
      .btnFloat:hover:before {
      }
      .btnFloat:hover:before {
        margin-top: -2px;
        margin-left: 0px;
        transform: scale(1.1,1.1);
        -ms-transform: scale(1.1,1.1);
        -webkit-transform: scale(1.1,1.1);
        box-shadow: 0px 5px 5px -2px rgba(0, 0, 0, 0.25);
      }
      /* SLIDE */
      .btnSlide.btnBlueGreen {
        background: 0;
      }
      .btnSlide .top {
        position: absolute;
        top: 0px;
        left: 0;
        width: 120px;
        height: 50px;
        background: #00AE68;
        z-index: 10;
        transition: all 0.2s ;
        border-radius: 5px;
      }
      .btnSlide.btnBlueGreen .top {
        background: #00AE68;
      }
      .btnSlide.btnLightBlue .top {
        background: #5DC8CD;
      }
      .btnSlide.btnOrange .top {
        background: #FFAA40;
      }
      .btnSlide.btnPurple .top {
        background: #A74982;
      }
      .btnSlide .bottom {
        position: absolute;
        top: 0;
        left: 0;
        width: 120px;
        height: 50px;
        color: #000;
        z-index: 5;
        border-radius: 5px;
      }
      .btnSlide:hover .top {
        top: 40px;
      }

      



html,
body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Mitr', sans-serif;
    font-size: 62.5%;
    font-size: 10px;


 
}
/*-- Inspiration taken from abdo steif -->
/* --> https://codepen.io/abdosteif/pen/bRoyMb?editors=1100*/
/* Navbar section */
.nav {
    width: 100%;
    height: 65px;
    position: fixed;
    line-height: 65px;
    text-align: center;
}
.nav div.logo {
    float: left;
    width: auto;
    height: auto;
    padding-left: 0rem;
    margin-left: -60pX;
}
.nav div.logo a {
    text-decoration: none;
    color: #fff;
    font-size: 2.5rem;
}
.nav div.logo a:hover {
    color: #00E676;
}
.nav div.main_list {
    height: 65px;
    float: right;
}
.nav div.main_list ul {
    width: 100%;
    height: 65px;
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}
.nav div.main_list ul li {
    width: auto;
    height: 65px;
    padding: 0;
    padding-right: 3rem;
}
.nav div.main_list ul li a {
    text-decoration: none;
    color: #fff;
    line-height: 65px;
    font-size: 2.4rem;
}
.nav div.main_list ul li a:hover {
    color: #00E676;
}

/* Home section */
.home {
    width: 100%;
    height: 100vh;
    background-image: url(./images/bg11.png);
    background-position: center top;
    background-size:cover;
    border: 0cm;

}
.navTrigger {
    display: none;
}
.nav {
    padding-top: 20px;
    padding-bottom: 20px;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
}

/* Media qurey section */
@media screen and (min-width: 768px) and (max-width: 1024px) {
    .container {
        margin: 0;
    }
}
@media screen and (max-width:768px) {
    .navTrigger {
        display: block;
    }
    .nav div.logo {
        margin-left: 15px;
    }
    .nav div.main_list {
        width: 100%;
        height: 0;
        overflow: hidden;
    }
    .nav div.show_list {
        height: auto;
        display: none;
    }
    .nav div.main_list ul {
        flex-direction: column;
        width: 100%;
        height: 100vh;
        right: 0;
        left: 0;
        bottom: 0;
        background-color: #111;
        /*same background color of navbar*/
        background-position: center top;
    }
    .nav div.main_list ul li {
        width: 100%;
        text-align: right;
    }
    .nav div.main_list ul li a {
        text-align: center;
        width: 100%;
        font-size: 3rem;
        padding: 20px;
    }
    .nav div.media_button {
        display: block;
    }
}

/* Animation */
/* Inspiration taken from Dicson https://codemyui.com/simple-hamburger-menu-x-mark-animation/ */
.navTrigger {
    cursor: pointer;
    width: 30px;
    height: 25px;
    margin: auto;
    position: absolute;
    right: 30px;
    top: 0;
    bottom: 0;
}
.navTrigger i {
    background-color: #fff;
    border-radius: 2px;
    content: '';
    display: block;
    width: 100%;
    height: 4px;
}
.navTrigger i:nth-child(1) {
    -webkit-animation: outT 0.8s backwards;
    animation: outT 0.8s backwards;
    -webkit-animation-direction: reverse;
    animation-direction: reverse;
}
.navTrigger i:nth-child(2) {
    margin: 5px 0;
    -webkit-animation: outM 0.8s backwards;
    animation: outM 0.8s backwards;
    -webkit-animation-direction: reverse;
    animation-direction: reverse;
}
.navTrigger i:nth-child(3) {
    -webkit-animation: outBtm 0.8s backwards;
    animation: outBtm 0.8s backwards;
    -webkit-animation-direction: reverse;
    animation-direction: reverse;
}
.navTrigger.active i:nth-child(1) {
    -webkit-animation: inT 0.8s forwards;
    animation: inT 0.8s forwards;
}
.navTrigger.active i:nth-child(2) {
    -webkit-animation: inM 0.8s forwards;
    animation: inM 0.8s forwards;
}
.navTrigger.active i:nth-child(3) {
    -webkit-animation: inBtm 0.8s forwards;
    animation: inBtm 0.8s forwards;
}

@-webkit-keyframes inM {
    50% {
        -webkit-transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(45deg);
    }
}
@keyframes inM {
    50% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(45deg);
    }
}
@-webkit-keyframes outM {
    50% {
        -webkit-transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(45deg);
    }
}
@keyframes outM {
    50% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(45deg);
    }
}
@-webkit-keyframes inT {
    0% {
        -webkit-transform: translateY(0px) rotate(0deg);
    }
    50% {
        -webkit-transform: translateY(9px) rotate(0deg);
    }
    100% {
        -webkit-transform: translateY(9px) rotate(135deg);
    }
}
@keyframes inT {
    0% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(9px) rotate(0deg);
    }
    100% {
        transform: translateY(9px) rotate(135deg);
    }
}
@-webkit-keyframes outT {
    0% {
        -webkit-transform: translateY(0px) rotate(0deg);
    }
    50% {
        -webkit-transform: translateY(9px) rotate(0deg);
    }
    100% {
        -webkit-transform: translateY(9px) rotate(135deg);
    }
}
@keyframes outT {
    0% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(9px) rotate(0deg);
    }
    100% {
        transform: translateY(9px) rotate(135deg);
    }
}
@-webkit-keyframes inBtm {
    0% {
        -webkit-transform: translateY(0px) rotate(0deg);
    }
    50% {
        -webkit-transform: translateY(-9px) rotate(0deg);
    }
    100% {
        -webkit-transform: translateY(-9px) rotate(135deg);
    }
}
@keyframes inBtm {
    0% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-9px) rotate(0deg);
    }
    100% {
        transform: translateY(-9px) rotate(135deg);
    }
}
@-webkit-keyframes outBtm {
    0% {
        -webkit-transform: translateY(0px) rotate(0deg);
    }
    50% {
        -webkit-transform: translateY(-9px) rotate(0deg);
    }
    100% {
        -webkit-transform: translateY(-9px) rotate(135deg);
    }
}
@keyframes outBtm {
    0% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-9px) rotate(0deg);
    }
    100% {
        transform: translateY(-9px) rotate(135deg);
    }
}
.affix {
    padding: 0;
    background-color: #111;
}





.myH2 {
	text-align:center;
	font-size: 4rem;
}
.myP {
	text-align: justify;
	padding-left:15%;
	padding-right:15%;
	font-size: 20px;
}
@media all and (max-width:700px){
	.myP {
		padding:2%;
	}
}
.borderDemo{
    border-radius: 40px;
    background-color: #00E676;
    }
    .wording {
        font-size: 20px;
    }

      


</style>

<!-- Jquery needed -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Function used to shrink nav bar removing paddings and adding black background -->
    <script>
        $(window).scroll(function() {
            if ($(document).scrollTop() > 50) {
                $('.nav').addClass('affix');
                console.log("OK");
            } else {
                $('.nav').removeClass('affix');
            }
        });

        $('.navTrigger').click(function () {
    $(this).toggleClass('active');
    console.log("Clicked menu");
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();

});



    </script>