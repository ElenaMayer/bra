// One point

/*if (jQuery("#googleMap").length > 0) {
    $obj = jQuery("#googleMap");
    var myLatlng = new google.maps.LatLng($obj.data("lat"), $obj.data("lon"));
    function initialize() {
        var mapProp = {
            center: myLatlng,
            zoom: 16,
            scrollwheel: false,
            mapTypeControlOptions: {
                mapTypeIds: [ google.maps.MapTypeId.ROADMAP, "map_style" ]
            }
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        var marker = new google.maps.Marker({
            position: myLatlng,
            icon: $obj.data("icon")
        });
        marker.setMap(map);
    }
    google.maps.event.addDomListener(window, "load", initialize);
}*/

// Two points

if (jQuery("#googleMap").length > 0) {
    $obj = jQuery("#googleMap");
    var myLatlngR = new google.maps.LatLng($obj.data("lat-r"), $obj.data("lon-r"));
    var myLatlngR2 = new google.maps.LatLng($obj.data("lat-r2"), $obj.data("lon-r2"));
    var myLatlngL = new google.maps.LatLng($obj.data("lat-l"), $obj.data("lon-l"));
    var myLatlngC = new google.maps.LatLng($obj.data("lat-c"), $obj.data("lon-c"));
    function initialize() {
        var mapProp = {
            center: myLatlngC,
            zoom: 12,
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
        var markerR2 = new google.maps.Marker({
            position: myLatlngR2,
            icon: $obj.data("icon")
        });
        markerR2.setMap(map);
        var markerL = new google.maps.Marker({
            position: myLatlngL,
            icon: $obj.data("icon")
        });
        markerL.setMap(map);
    }
    google.maps.event.addDomListener(window, "load", initialize);
}