<?php 
error_reporting(E_ALL);
require("../db.php");
require("../functions.php");
//print_r(get_defined_constants(true));
//echo "hello";
//print_r(geocode("Billings MT 59101 USA"));
// function to geocode address, it will return false if unable to geocode address

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Markers</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=<? echo MAPS_API_KEY; ?>&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script>
  
	const uscenter = {
        lat: 37.0902,
        lng: -95.7129
    };
      function initMap() {

        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 4,
          center: uscenter
        });
        
		

<?
$members=MDB::query("SELECT * FROM atn_cmr");

foreach ($members as $row) {
	
	$text= 'const marker_'.$row["id"].'_coord = {
        lat: '.$row["lati"].',
        lng: '.$row["longi"].'
    };

	new google.maps.Marker({
        position: marker_'.$row["id"].'_coord,
        map,
        title: "Hello World!"
       });
		
	var marker_'.$row["id"].'_data = \'<div id="content">\'+
    \'<div id="siteNotice">\'+
    \'</div>\'+
    \'<h1 id="firstHeading" class="firstHeading">Uluru</h1>\'+
    \'<div id="bodyContent">\'+
    \'hello world\'+
    \'</div>\'+
    \'</div>\';

	var marker_'.$row["id"].'_infowindow = new google.maps.InfoWindow({
		content: marker_'.$row["id"].'_data
	});

	var marker_'.$row["id"].' = new google.maps.Marker({
		position: marker_'.$row["id"].'_coord,
		map: map,
		title: \'Uluru (Ayers Rock)\'
	});
	
	marker_'.$row["id"].'.addListener(\'click\', function() {
		marker_'.$row["id"].'_infowindow.open(map, marker_'.$row["id"].'_infowindow);
	});';
	  echo $text;
}
?>
      
	  
	  
	  
	  
	  
	  }
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
    </script>
  </head>
  <body>
    <div id="map" style="width: 500px; height: 400px;"></div>
  </body>
</html>
