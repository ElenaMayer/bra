if (jQuery("#googleMap").length > 0) {
    $obj = jQuery("#googleMap");
    var myLatlngR = new google.maps.LatLng($obj.data("lat-r"), $obj.data("lon-r"));
    var myLatlngL = new google.maps.LatLng($obj.data("lat-l"), $obj.data("lon-l"));
    var myLatlngC = new google.maps.LatLng($obj.data("lat-c"), $obj.data("lon-c"));
    function initialize() {
        var mapProp = {
            center: myLatlngC,
            zoom: 12.5,
            scrollwheel: false,
            mapTypeControlOptions: {
                mapTypeIds: [ google.maps.MapTypeId.ROADMAP, "map_style" ]
            }
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        var markerR = new google.maps.Marker({
            position: myLatlngR,
            icon: $obj.data("icon")
        });
        markerR.setMap(map);
        var markerL = new google.maps.Marker({
            position: myLatlngL,
            icon: $obj.data("icon")
        });
        markerL.setMap(map);
    }
    google.maps.event.addDomListener(window, "load", initialize);
}