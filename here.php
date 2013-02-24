<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>INSERT TITLE HERE</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">


<!--replace to min in production-->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="apple-touch-fullscreen" content="yes" />

<!--insert apple icons, here-->
<link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-114.png" />
<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114.png" />
<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-144.png" />
<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144.png" />

<script>
    	
$(function() {
var draw_circle = null; 
function drawCircle(p,map){
    if (draw_circle != null) {
        draw_circle.setMap(null);
    }
    draw_circle = new google.maps.Circle({
        center: new google.maps.LatLng(p.coords.latitude,p.coords.longitude),
        radius: p.coords.accuracy,
        strokeColor: "#6666CC",
        strokeOpacity: 0.5,
        strokeWeight: 1,
        fillColor: "#6666CC",
        fillOpacity: 0.35,
        map: map
    });
    if(map.getZoom()>18) map.fitBounds(draw_circle.getBounds()); else
    map.setZoom(18);
}

function geoError(error){
  switch(error.code){
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.")
      break;
    case error.POSITION_UNAVAILABLE:
     alert("Location information is unavailable.")
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.")
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.")
      break;
    }
  }

   function load_marker(o,map){
     		var marker=new google.maps.Marker({
			  position: new google.maps.LatLng(o["lat"],o["lon"]),
			  map: map,
			  title: o["title"]
			});
			var contentString = '<form data-ajax="false" action="api.php" method="post">'+
			'<label for="title" class="ui-hidden-accessible">Title:</label><input type="text" name="title" id="title" value="'+o["title"]+'" placeholder="Title"/>'+
			'<label for="line1" class="ui-hidden-accessible">line1</label><input type="text" name="line1" id="line1" value="'+o["line2"]+'" placeholder="Title"/>'+
			'<input type="hidden" name="lat" value="'+o["lat"]+'"/>'+
			'<input type="hidden" name="lon" value="'+o["lon"]+'"/>'+
			'<input type="hidden" name="id" value="'+o["id"]+'"/>'+
			'<input name="action" type="submit" value="update"/><input name="action" type="submit" value="delete"/>'+
			'</form>';
			marker.infowindow = new google.maps.InfoWindow({
				content: contentString
			});
			//marker.infowindow.open(map,marker);
			//marker.setAnimation(google.maps.Animation.BOUNCE);
			/*
			google.maps.event.addListener(marker.infowindow,'closeclick',function(){
  			 	 marker.setAnimation(null);
  			 });
			google.maps.event.addListener(marker, 'click', function() {  
				marker.infowindow.open(map,marker);
				marker.setAnimation(google.maps.Animation.BOUNCE);	
			});*/
     }

if(navigator.geolocation){
	navigator.geolocation.getCurrentPosition(function(p){
  		var temp=
  		"Lat:"+p.coords.latitude +
  		"<br>Longitude: " + p.coords.longitude +
  		"<br>Accuracy: " + p.coords.accuracy +
  		"<br>Altitude: " + p.coords.altitude +
  		"<br>AltitudeAccuracy: " + p.coords.altitudeAccuracy +
  		"<br>heading: " + p.coords.heading+
  		"<br>speed: " + p.coords.speed
  		$("#formLat").val(p.coords.latitude)
  		$("#formLon").val(p.coords.longitude)
  		$("#map_canvas").height($(window).height()/2)  
  		 var map = new google.maps.Map(document.getElementById('map_canvas'),{
          zoom: 18,
          center: new google.maps.LatLng(p.coords.latitude,p.coords.longitude),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: true,
          disableDoubleClickZoom: true,
          scrollwheel: false,
		  draggable: false,
          backgroundColor: "#333333",
          styles:[{
			featureType:"all",
			elementType:"all",
			stylers:[{
				visibility:"off"
				}]
    		},{
			featureType:"road",
			elementType:"all",
			stylers:[{
				visibility:"on"
				},{saturation:-100}]
    		}]
		});

/*
		$.getJSON('api.php',function(o){
        	$.each(o,function(i,v){
        		load_marker(v,map);
        	})
        })
*/
        drawCircle(p,map);
		var marker=new google.maps.Marker({
		  position: new google.maps.LatLng(p.coords.latitude,p.coords.longitude),
		  map: map,
		  title: "centre"
		});
		marker.setAnimation(google.maps.Animation.BOUNCE);
		
		gid=navigator.geolocation.watchPosition(function(p){
			var curr=new google.maps.LatLng(p.coords.latitude,p.coords.longitude);
			map.setCenter(curr);
			marker.setPosition(curr)
			drawCircle(p,map);
			//$("#out").html(showPosition(p))
			$("#formLat").val(p.coords.latitude)
  			$("#formLon").val(p.coords.longitude)
  			$("#formAcc").val(p.coords.accuracy)
  			$("#formAlt").val(p.coords.altitude)
  			$("#formAltAcc").val(p.coords.altitudeAccuracy)
			//if(p.coords.accuracy<=10) navigator.geolocation.clearWatch(gid)
		}, geoError, {enableHighAccuracy:true, maximumAge:1000, timeout:27000})
	},function(error){
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.")
      break;
    case error.POSITION_UNAVAILABLE:
     alert("Location information is unavailable.")
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.")
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.")
      break;
    }
  }, { enableHighAccuracy: true });
} else {
	alert("not supported")
}


})
</script>
</head>
<body>
<div class="container">
<div id="map_canvas"></div>
<form>
<input type="text" class="input-block-level" name="title" placeholder="Title.."/>
<input type="hidden" id="formLat" name="lat"/>
<input type="hidden" id="formLon" name="lon"/>
<input type="hidden" id="formAcc" name="acc"/>
<input type="hidden" id="formAlt" name="alt"/>
<input type="hidden" id="formAltAcc" name="altAcc"/>
<input type="submit" class="btn btn-block" value="Save Location"/>
</form><!-- /grid-a -->	
</div>
</body>
</html>