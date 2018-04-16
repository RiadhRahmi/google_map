(function ($, Drupal) {
    Drupal.behaviors.mapsBehavior = {
        attach: function (context, settings) {

            var google_api_key = settings.api_key;
            var zoom = settings.zoom;
            var center_position = settings.center.split(",");
            var center_lat = center_position[0] ;
            var center_long = center_position[1];
            var markers = settings.markers.split("|");

            $.getScript('https://maps.googleapis.com/maps/api/js?key='+google_api_key,function () {

                var myCenter = new google.maps.LatLng(center_lat,center_long);
                var mapCanvas = document.getElementById("googleMap");
                var mapOptions = {
                    center: myCenter,
                    zoom: parseInt(zoom)
                };

                var map = new google.maps.Map(mapCanvas, mapOptions);

                var arrayLength = markers.length;
                for (var i = 0; i < arrayLength; i++) {
                    var mar = markers[i].split(",");
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(mar[0],mar[1])
                    });
                    marker.setMap(map);
                }



            });



        }
    };
})(jQuery, Drupal);


