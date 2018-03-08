// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
//

var map;
var markers;
var bounds;

function place_changer(autocomplete) {
  autocomplete.addListener('place_changed', function (e) {
    var place = autocomplete.getPlace();

    if (!place.geometry) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || ''),
      ].join(' ');
    }

    if (map) {
      setMarker(address,place);
    }

  },
  {capture: true},
  {passive: true});
}

function setMarker(address,place) {
  // If the place has a geometry, then present it on a map.

  if (document.getElementById('map')) {

    var infowindowContent = document.getElementById('infowindow-content');
    var hiddenForm = $('#infowindow-content').children('#GMapVals');
    console.log(hiddenForm);

    hiddenForm.children('#lat').val(place.geometry.location.lat());
    hiddenForm.children('#lng').val(place.geometry.location.lng());
    hiddenForm.children('#name').val(place.name);

    infowindowContent.children['place-icon'].src = place.icon;
    infowindowContent.children['place-name'].textContent = place.name;
    infowindowContent.children['place-address'].textContent = address;

    var infowindow = new google.maps.InfoWindow();
    infowindow.setContent(infowindowContent.innerHTML);

    var marker = new google.maps.Marker({
      map: map,
      anchorPoint: new google.maps.Point(0, -29)
    });

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    infowindow.open(map, marker);

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(10);
    }
  }
  return hiddenForm;
}

function initMap() {
  if (document.getElementById('map')) {

    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat:53.2, lng: -4.574},
      zoom: 10
    });

    var card = document.getElementById('pac-card');
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    var autocompleters = document.getElementsByClassName('location')
    console.log(autocompleters);
    for (var i=0; i<autocompleters.length;i++) {
      // Initialise the Google maps autocomplete API for the input
      autocomplete=new google.maps.places.Autocomplete(autocompleters[i]);
      // Bind the map's bounds (viewport) property to the autocomplete object,
      autocomplete.bindTo('bounds', map);
      // Create marker and tab for new location
      place_changer(autocomplete,map);
    }
  }
  getFavourites();
  return map;

}
