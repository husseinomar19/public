jQuery(document).ready(function ($) {
    $('#event-form').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.post(eventMapData.ajax_url, formData, function (response) {
            if (response.success) {
                alert('Evenement opgeslagen!');
                initializeMap(response.data);
            } else {
                alert('Er ging iets mis.');
            }
        });
    });

    function initializeMap(eventData) {
        var map = new google.maps.Map(document.getElementById('event-map'), {
            center: { lat: 52.370216, lng: 4.895168 }, // Amsterdam als voorbeeld
            zoom: 8,
        });

        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({ address: eventData.location }, function (results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    title: eventData.name,
                });
            } else {
                alert('Locatie niet gevonden: ' + status);
            }
        });
    }
});
