var geocoder;
var map;
var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var path = [];
$(document).ready(function(){
    directionsDisplay = new google.maps.DirectionsRenderer();
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(45.2175031, -122.1966923);
    geoaddr('1330 se cowls, McMinnville OR 97128');
    var myOptions = {
      zoom: 13,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("googlemap"),myOptions);
    if(navigator.geolocation){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var pos = new google.maps.LatLng(lat, lng);
                var options = { position:pos, map:map }
                var marker = new google.maps.Marker(options);
                marker.setMap(map);   
                path[1] = pos;
                directionsDisplay.setMap(map);
                calcRoute(path);
            });
        }
    }
    
});
function geoaddr(addr){
    geocoder.geocode( { 'address':addr }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      path[0] = results[0].geometry.location;
      var marker = new google.maps.Marker({
          map: map, 
          position: results[0].geometry.location
      });
    }
  });
}
function calcRoute(path) {
  var start = path[1];
  var end = path[0];
  var request = {
    origin:start, 
    destination:end,
    travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
}