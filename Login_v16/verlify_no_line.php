<html>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <!-- Icon -->
    <div class="fadeIn first">
    <br>
    <br>
    <img style="height:100px;width:100px;" src="images/line.png" alt="" /></a>
    <img style="height:100px;width:100px;" src="images/switch.png" alt="" /></a>
    <br>
    <br>
    บัญชี : <?php echo $username; ?>
    <center><label class="fontf" style="font-size:20px;">
    <br>เนื่องจากมีการเชื่อมต่อไว้แล้ว<br>
       หากต้องการเชื่อมต่อ LINE บัญชีใหม่ กด'ตกลง'
    </label>
    <br>
    
    </center>
    <br>
    <br>
    </div>

    <!-- Remind Passowrd -->
    <input hidden id="uid"  value="<?php echo $link_back_line; ?>" >
    <div style="color:#fff" id="formFooter">
      <a class="btn btn-secondary" onclick="OK()"  class="underlineHover" >ตกลง</a>
      <a class="btn btn-danger" onclick="goBack()"  class="underlineHover" >ยกเลิก</a>
    </div>

  </div>
</div>
<style>
.fontf{
  font-family: 'Kanit', sans-serif;
}

body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
}

a {
  color: #92badd;
  display:inline-block;
  text-decoration: none;
  font-weight: 400;
}
/* STRUCTURE */

.wrapper {
  display: flex;
  align-items: center;
  flex-direction: column; 
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
  background-image: url("images/bg33.jpg");
  background-size:cover;
 
}
#formContent {
  -webkit-border-radius: 10px 10px 10px 10px;
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  padding: 30px;
  width: 90%;
  max-width: 450px;
  position: relative;
  padding: 0px;
  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  text-align: center;
}

#formFooter {
  background-color: #f6f6f6;
  border-top: 1px solid #dce8f1;
  padding: 25px;
  text-align: center;
  -webkit-border-radius: 0 0 10px 10px;
  border-radius: 0 0 10px 10px;
}




@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fadeIn {
  opacity:0;
  -webkit-animation:fadeIn ease-in 1;
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}



/* OTHERS */

*:focus {
    outline: none;
} 

#icon {
  width:60%;
}
</style>
</html>


<script>
    $(document).ready(function() {
  $('#login ').hide();
  $('#body_login').hide();   


});

function OK(){
    var uid = document.getElementById('uid').value;
    console.log(uid);
    location.href = uid;
 
}
</script>