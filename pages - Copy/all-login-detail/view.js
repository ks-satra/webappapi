$(function() {
	
});
var map;
var marker = null;
function initMap() {
	var data = JSON.parse( $("#data").val() );
	var more = JSON.parse( data.json_ip );
	var loc = more.loc;
	var arr = loc.split(",");
	if( arr.length == 2 ) {
		var lat = arr[0]*1;
		var lng = arr[1]*1;
		var name = loc;
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: lat, lng: lng},
			zoom: 15
		});
		makeMarker(lat, lng, name);
	}
}
function makeMarker(lat, lng, name){
	if(marker!=null) marker.setMap(null);
	marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat,lng),
		title: name,
	});
	marker.setMap(map);
}