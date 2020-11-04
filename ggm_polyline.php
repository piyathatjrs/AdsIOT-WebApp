<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Google Map API 3 - 01</title>
<style type="text/css">
html {
	height: 100%
}
body {
	height:100%;
	margin:0;
	padding:0;
	font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;
	font-size:12px;
}
/* css กำหนดความกว้าง ความสูงของแผนที่ */
#map_canvas {
	position:relative;
	width:550px;
	height:400px;
	margin:auto;/*	margin-top:100px;*/
}
#contain_map {
	position:relative;
	width:550px;
	height:400px;
	margin:auto;
	margin-top:50px;
}
/* css ของส่วนการกำหนดจุดเริ่มต้น และปลายทาง */  
#showDD {
	position:absolute;
	bottom:0px;
	/*    background-color:#000;  */
    color:#FFF;
}
#show_form_data {
	margin:auto;
	width:550px;
}
#hand_b {
	width:31px;
	height:31px;
	cursor:pointer;
	background-image: url(images/Bsu.png);
}
#hand_b.selected {
	background-image: url(images/Bsd.png);
}
#placemark_b {
	width:31px;
	height:31px;
	cursor:pointer;
	background-image: url(images/Bmu.png);
}
#placemark_b.selected {
	background-image: url(images/Bmd.png);
}
#line_b {
	width:31px;
	height:31px;
	cursor:pointer;
	background-image: url(images/Blu.png);
}
#line_b.selected {
	background-image: url(images/Bld.png);
}
#shape_b {
	width:31px;
	height:31px;
	cursor:pointer;
	background-image: url(images/Bpu.png);
}
#shape_b.selected {
	background-image: url(images/Bpd.png);
}
</style>
</head>

<body>
<div id="contain_map">
  <div id="map_canvas"></div>
  <div id="showDD">
    <table>
      <tr>
        <td><div id="hand_b"
	 onclick="stopEditing()"/></td>
        <td><div id="placemark_b"
	 onclick="placeMarker()"/></td>
        <td><div id="line_b"
	 onclick="startLine()"/></td>
        <td><div id="shape_b"
	onclick="startShape()"/></td>
      </tr>
    </table>
  </div>
</div>
<div id="show_form_data">
  <form id="form_get_detailMap" name="form_get_detailMap" method="post" action="">
    Path Array<br />
    <textarea name="path_arr" id="path_arr" cols="70" rows="5"></textarea>
    <br />
    Distance<br />
    <input name="distance" type="text" id="distance" value="" />
    Km&nbsp; (หากเป็น poligon จะเป็นขนาดความยาวโดยรอบ)<br />
    Area<br />
    <input name="area_data" type="text" id="area_data" value="" />
    m<sup>2</sup> (หาร 1000000 จะได้ เท่ากับหน่วย km<sup>2</sup>)<br />
    <input type="submit" name="button" id="button" value="บันทึก" />
  </form>
</div>

<!--<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
<script type="text/javascript">

/* ส่วนสำหรับการ random ค่าสีและ event */
var COLORS =[
	["red", "#ff0000"], 
	["orange", "#ff8800"],
	["green","#008000"],
	["blue", "#000080"],
	["purple", "#800080"]
];
var colorIndex_ = 0;
var listener;

 /* ส่วนของการกำหนดค่า สำหรับคำนวณพื้นที่ */
var earthRadiusMeters=6367460.0;
var metersPerDegree=2.0*Math.PI*earthRadiusMeters/360.0;
var degreesPerRadian=180.0/Math.PI;
var radiansPerDegree=Math.PI/180.0;
var metersPerKm=1000.0;
 
 
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
var poly;
var polygon;
var marker=[];
var Points=[];

function swap_class(buttonId) {
	$("#hand_b").removeClass("selected");
	$("#shape_b").removeClass("selected");
	$("#line_b").removeClass("selected");
	$("#placemark_b").removeClass("selected");
	$("#"+buttonId).addClass("selected");
}

function stopEditing() {
	swap_class("hand_b");
	$("#path_arr").val("");
	$("#distance").val("");
	$("#area_data").val("");
	if(listener!=undefined){
		GGM.event.removeListener(listener);
	}
	if(poly!=undefined){
		poly.setMap(null);
	}
	if(polygon!=undefined){
		polygon.setMap(null);
	}	
	if(marker.length>0){
		for(i=0;i<marker.length;i++){
			marker[i].setMap(null);
		}
	}
}
 
function getColor(named) {
  return COLORS[(colorIndex_++) % COLORS.length][named ? 0 : 1];
}
 
function getIcon(color) {
  var icon = new GIcon();
  icon.image = "http://google.com/mapfiles/ms/micons/" + color + ".png";
  icon.iconSize = new GSize(32, 32);
  icon.iconAnchor = new GPoint(15, 32);
  return icon;
}
 

function startShape(){
 	swap_class("shape_b");	
	var color = getColor(true);
    var polygonOptions = {
      strokeColor: color,
	  geodesic:true,
      strokeOpacity: 1.0,
      strokeWeight: 3,
      fillColor: color,
      fillOpacity: 0.35	  
    }
    polygon = new GGM.Polygon(polygonOptions);
    polygon.setMap(map);
	
	startDrawing2(polygon,color);
	
}

function startLine() {
  swap_class("line_b");
	var color = getColor(true);
    var polyOptions = {
      strokeColor: color,
	  geodesic:true,
      strokeOpacity: 1.0,
      strokeWeight: 3
    }
    poly = new GGM.Polyline(polyOptions);
    poly.setMap(map);
	
	startDrawing(poly,color);

}
function startDrawing2(polygon,color){
		var i=0;
		Points=[];
		listener=GGM.event.addListener(map, 'click', function(event){

			var path = polygon.getPath();

			path.push(event.latLng);
			Points.push(event.latLng);
			

			var data_path="";
			var points='';
            $.each(path.getArray(),function(j,k){
                k=k.toString().replace("(","").replace(")","").replace(" ","");
                data_path+=k+"\r\n";
            });            

			$("#path_arr").val(data_path);
			$("#distance").val(polygon.inKm());
			calculateArea(Points);
		 
			// Add a new marker at the new plotted point on the polyline.
			var image="http://google.com/mapfiles/ms/micons/"+color+".png";
			marker[i] = new GGM.Marker({
			  position: event.latLng,
			  title: '#' + path.getLength(),
			  map: map,
			  icon: image
			});  
			i++;
		});			
}

function calculateArea(points) {
    if(points.length>2) {
        var areaMeters2=PlanarPolygonAreaMeters2(points);
        if(areaMeters2>1000000.0) areaMeters2=SphericalPolygonAreaMeters2(points);
		$("#area_data").val(areaMeters2.toFixed(2));
    }
}
function PlanarPolygonAreaMeters2(points) {
    var a=0.0;
    for(var i=0;i<points.length;++i)
        {var j=(i+1)%points.length;
        var xi=points[i].lng()*metersPerDegree*Math.cos(points[i].lat()*radiansPerDegree);
        var yi=points[i].lat()*metersPerDegree;
        var xj=points[j].lng()*metersPerDegree*Math.cos(points[j].lat()*radiansPerDegree);
        var yj=points[j].lat()*metersPerDegree;
        a+=xi*yj-xj*yi;}
    return Math.abs(a/2.0);
}
function SphericalPolygonAreaMeters2(points) {
    var totalAngle=0.0;
    //alert(points[0]);
    for(i=0;i<points.length;++i)
        {var j=(i+1)%points.length;
        var k=(i+2)%points.length;
        totalAngle+=Angle(points[i],points[j],points[k]);}
    var planarTotalAngle=(points.length-2)*180.0;
    var sphericalExcess=totalAngle-planarTotalAngle;
    if(sphericalExcess>420.0)
        {totalAngle=points.length*360.0-totalAngle;
        sphericalExcess=totalAngle-planarTotalAngle;}
    else if(sphericalExcess>300.0&&sphericalExcess<420.0)
        {sphericalExcess=Math.abs(360.0-sphericalExcess);}
    return sphericalExcess*radiansPerDegree*earthRadiusMeters*earthRadiusMeters;
}
function Angle(p1,p2,p3) {
    var bearing21=Bearing(p2,p1);
    var bearing23=Bearing(p2,p3);
    var angle=bearing21-bearing23;
    if(angle<0.0) angle+=360.0;
    return angle;
}
function Bearing(from,to) {
    var lat1=from.lat()*radiansPerDegree;
    var lon1=from.lng()*radiansPerDegree;
    var lat2=to.lat()*radiansPerDegree;
    var lon2=to.lng()*radiansPerDegree;
    var angle=-Math.atan2(Math.sin(lon1-lon2)*Math.cos(lat2),Math.cos(lat1)*Math.sin(lat2)-Math.sin(lat1)*Math.cos(lat2)*Math.cos(lon1-lon2));
    if(angle<0.0) angle+=Math.PI*2.0;
    angle=angle*degreesPerRadian;
    return angle;
}
 



function startDrawing(poly,color){
	var i=0;
	listener=GGM.event.addListener(map, 'click', function(event){
		var path = poly.getPath();

		path.push(event.latLng);
		var data_path="";
		$.each(path.getArray(),function(j,k){
            k=k.toString().replace("(","").replace(")","").replace(" ","");
			data_path+=k+"\r\n";
		});
		$("#path_arr").val(data_path);
		$("#distance").val(poly.inKm());

		// Add a new marker at the new plotted point on the polyline.
		var image="http://google.com/mapfiles/ms/micons/"+color+".png";
		marker[i] = new GGM.Marker({
		  position: event.latLng,
		  title: '#' + path.getLength(),
		  map: map,
		  icon: image
		});  
		i++;
	});			
}


function placeMarker() {
	swap_class("placemark_b");
	var i=0;
	listener=GGM.event.addListener(map, 'click', function(event){
		if(event.latLng){
			var color = getColor(true);
			var image="http://google.com/mapfiles/ms/micons/"+color+".png";
			marker[i] = new GGM.Marker({
				position: event.latLng,
				map: map,
				icon: image
			});
			i++;
		}
	});

}
 
function initialize() { // ฟังก์ชันแสดงแผนที่
	GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
	// กำหนดจุดเริ่มต้นของแผนที่
	var my_Latlng  = new GGM.LatLng(13.761728449950002,100.6527900695800);
	var my_mapTypeId=GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
	// กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
	var my_DivObj=$("#map_canvas")[0]; 
	// กำหนด Option ของแผนที่
	var myOptions = {
		zoom: 15, // กำหนดขนาดการ zoom
		center: my_Latlng , // กำหนดจุดกึ่งกลาง
		mapTypeId:my_mapTypeId // กำหนดรูปแบบแผนที่
	};
	map = new GGM.Map(my_DivObj,myOptions);// สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map

  GGM.LatLng.prototype.kmTo = function(a){ 
    var e = Math, ra = e.PI/180; 
    var b = this.lat() * ra, c = a.lat() * ra, d = b - c; 
    var g = this.lng() * ra - a.lng() * ra; 
    var f = 2 * e.asin(e.sqrt(e.pow(e.sin(d/2), 2) + e.cos(b) * e.cos 
(c) * e.pow(e.sin(g/2), 2))); 
    return f * 6378.137; 
  } 

  GGM.Polyline.prototype.inKm = function(n){ 
    var a = this.getPath(n), len = a.getLength(), dist = 0; 
    for(var i=0; i<len-1; i++){ 
      dist += a.getAt(i).kmTo(a.getAt(i+1)); 
    } 
    return dist; 
  }
  
  GGM.Polygon.prototype.inKm = function(n){ 
    var a = this.getPath(n), len = a.getLength(), dist = 0; 
	var dist2=0;
    for(var i=0; i<len-1; i++){ 
      dist += a.getAt(i).kmTo(a.getAt(i+1)); 
    } 
	dist2+=a.getAt(len-1).kmTo(a.getAt(0)); 
    return dist+dist2; 
  }  
  
}
$(function(){
	// โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
	// ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
	// v=3.2&sensor=false&language=th&callback=initialize
	//	v เวอร์ชัน่ 3.2
	//	sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
	//	language ภาษา th ,en เป็นต้น
	//	callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
	$("<script/>", {
	  "type": "text/javascript",
	  src: "http://maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize"
	}).appendTo("body");	
});
</script>
</body>
</html>