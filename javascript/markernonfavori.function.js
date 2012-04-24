// JavaScript Document
//marker non favori
function createMarker(location)
{
var marker = new google.maps.Marker( {
		position : location,
		draggable:true,
		map : document.map		
	});

google.maps.event.addListener(marker, 'click', function() {
	var posiactu=marker.getPosition();	
	document.geocoder.geocode({'latLng': posiactu}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {		       
		          var adresse= results[0].formatted_address;
		          var country = getCountry(adresse);
		      	var city = getCity(adresse);
		      	var cp = getPostalCode(adresse);
		      	var shoradr = getShortAddress(adresse);
		      	document.getElementById('txtAddress').value = shoradr;
		      	document.getElementById('country').value = country;
		      	document.getElementById('city').value = city;
		      	document.getElementById('codepostal').value = cp;
		      	document.getElementById('txtLabel').value = "";
		      	document.getElementById('txtComment').value = "";		         
		      } else {
		        alert("Geocoder failed due to: " + status);
		      }
		    });	
	});

google.maps.event.addListener(marker, 'dragend', function() {
	var posiactu=marker.getPosition();	
	document.geocoder.geocode({'latLng': posiactu}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {		       
		          var adresse1= results[0].formatted_address;
		          var country1 = getCountry(adresse1);
		      	var city1 = getCity(adresse1);
		      	var cp1 = getPostalCode(adresse1);
		      	var shoradr1 = getShortAddress(adresse1);
		      	document.getElementById('txtAddress').value = shoradr1;
		      	document.getElementById('country').value = country1;
		      	document.getElementById('city').value = city1;
		      	document.getElementById('codepostal').value = cp1;
		      	document.getElementById('txtLabel').value = "";
		      	document.getElementById('txtComment').value = "";		         
		      } else {
		        alert("Geocoder failed due to: " + status);
		      }
		    });	
});

}


function checkAddress()
{
var adr=document.getElementById('txtAddress').value+","+document.getElementById('city').value;
document.geocoder.geocode( {
		'address' : adr
	}, afficherMarkers);
}

function afficherMarkers(results, status)
{
	for(var i=0;i<results.length;i++)
	{
var address = results[i].formatted_address;
if(getShortAddress(address)!="")
{
var location= results[i]. geometry.location;
 createMarker(address,location);
	document.map.setCenter(location);
	document.map.setZoom(ADDRESS_ZOOM_LEVEL);
}

	}
	}