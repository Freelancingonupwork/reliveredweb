jQuery(document).ready(function() {
    jQuery('#contact-form').on('click', function(e) {
      e.preventDefault();
      jQuery('#contactformModal').modal('show');
    });

    
})

document.addEventListener( 'wpcf7mailsent', function( event ) {
  jQuery('#contactformModal').modal('hide');
}, false );
var locations = [];
jQuery.ajax({
  url: relivery.ajax_url,
  type: 'POST',
  data: {
      action: 'available_lockers'
  },
  dataType: 'json',
  success: function(response) {
 
    // Check if the request was successful, otherwise show an error message.
    
    if (response.success) {
        var data = response.data;
        var newLocations = [];
        jQuery.each(data, function(index, value) {
            var location = {
                title: value.title,
                lat: parseFloat(value.latitude),
                lng: parseFloat(value.longitude),
                locker_type: value.locker_type
            };
            newLocations.push(location);
        });
        locations = newLocations;
        initMap();
    } else {
        console.log(response.message);
    }
  },
  error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
  }
});

function initMap() {
  var map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 21.3246, lng: 72.995 },
      zoom: 11
  });

  var infowindow = new google.maps.InfoWindow();

  for (var i = 0; i < locations.length; i++) {
      var location = locations[i];
     var markerColor = (location.locker_type === "PUBLIC") ? "blue" : "red"; // set marker color based on locker type
      var marker = new google.maps.Marker({
          position: { lat: location.lat, lng: location.lng },
          map: map,
          title: location.title,
          icon: {
            url: `http://maps.google.com/mapfiles/ms/icons/${markerColor}-dot.png`
          }
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
              infowindow.setContent(location.title);
              infowindow.open(map, marker);
          }
      })(marker, i));
  }
}

