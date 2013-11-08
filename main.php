<?php
class Weather{
	public static $apiRoot = 'http://api.openweathermap.org/data/2.5/weather';
	public static $apikey = '4551942225516d4913622e592a19627d';

	public static function getWeather($lat,$lon){
		$api = Weather::$apiRoot.'?lat='.$lat.'&lon='.$lon.'&APPID='.Weather::$apikey;
		$data = file_get_contents($api);
		echo $data;
	}
}

if($_SERVER['REQUEST_METHOD']=="POST"){
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	Weather::getWeather($lat,$lon);
	exit();
}
?>


<!doctype html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">
        <title>Hi</title>
        
        <style>
            @import url(http://fonts.googleapis.com/css?family=Dosis:300,400&subset=latin,latin-ext);
			body{font-family:'Dosis', sans-serif;margin:0;padding:0 0 50px;}
			h1{color:#00BCF6; letter-spacing: 2px;font-family:'Dosis', sans-serif;}
			.header,.footer{line-height:50px;height:50px;width:100%;}
			.header h1,.header a{display:inline-block;}
			.header h1{font-weight:400;margin:0;}
			.footer{}
			.content{padding:25px 0; width:80%; margin:0 auto; text-align: center;}
                        label,input,.error{clear:both;float:left;margin:5px 0;}
                        .hell{padding:10px;background:#921;color:#efefef;}
                        .well{padding:10px;background:#291;color:#efefef;}
        </style>
    </head>
    <body>
        <div class="content">

            <h1>...</h1>
            <h2 id="desc">Wait, I am looking outside.</h2>
           
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <script>
        $(document).ready(function(){
        	function displayError(){}
			function displayPosition(position) {
			  //alert("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude);
			  $.post("/",{lat:position.coords.latitude,lon:position.coords.longitude},
			  	function(data){
			  		dataObj = JSON.parse(data);
			  		console.log(dataObj);
                                        desc = dataObj.weather[0].description;
                                        if(desc.search('rainy')>0){
                                            $("h1").addClass('hell');
                                            $("h1").html("Hell Yes!"); 
                                        }else{
                                            $("h1").addClass('well');
                                            $("h1").html("No!"); 
                                        }
                                        $("#desc").html(desc); 
			  	})
			}
			if (navigator.geolocation) {
			  var timeoutVal = 10 * 1000 * 1000;
			  navigator.geolocation.getCurrentPosition(
			    displayPosition, 
			    displayError,
			    { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
			  );
			}
			else {
			  alert("Geolocation is not supported by this browser");
			}
        })

</script>
    </body>
</html>


