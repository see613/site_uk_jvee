
function initMap(elementId, lat, lng, zoom) {
    var myLatLng = {lat: lat, lng: lng};

    // Create a map object and specify the DOM element for display.
    var map = new google.maps.Map(document.getElementById(elementId), {
        center: myLatLng,
        zoom: zoom,
        scrollwheel: false,
        draggable: !("ontouchend" in document),
        disableDefaultUI: true
    });
    /*map.setOptions({
        styles:
            [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
    });*/

    var markerIcon = new google.maps.MarkerImage(
        '/images/marker.png',
        new google.maps.Size(59,98),
        new google.maps.Point(0,0),
        new google.maps.Point(30,85)
    );
    var marker = new google.maps.Marker({
        map: map,
        position: myLatLng,
        //icon: markerIcon,
        title: 'JV Electrical Essex Ltd'
    });
}


function initAllMaps() {
    initMap('map', 51.644792, 0.279658, 16);
}




