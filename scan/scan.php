<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        #mycanvas{
            width: 500px;
            height: 500px;
            border: solid 2px #CCC;
            padding: 10px;
        }

</style>
</head>
<body>
    <canvas id="mycanvas"></canvas><br>
    <button id="btnScan">Scan Now</button>

    <script
  src="http://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

  <script src="dw-qrscan.js"></script>
  <script src="jsQR.js"></script>

  <script>
      DWTQR("mycanvas");
      $("#btnScan").click(function(){
     dwStartScan();

      });
      function dwQRReader( data ){
            // alert(data);
            window.location = data;
      
      }
  </script>
</body>
</html>