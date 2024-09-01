function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -28.681709540162558, lng: -49.37358875197284 },
        zoom: 20,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const marker = new google.maps.Marker({
        position: map.getCenter(),
        map: map,
        draggable: true
    });

    google.maps.event.addListener(marker, 'position_changed', function() {
        const lat = marker.getPosition().lat();
        const lng = marker.getPosition().lng();
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    });

    // Configurar o SearchBox
    const addressInput = document.getElementById('address-input');
    const searchBox = new google.maps.places.SearchBox(addressInput);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(addressInput);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('search-button'));

    // Adicionar evento de mudança no SearchBox
    google.maps.event.addListener(searchBox, 'places_changed', function() {
        const places = searchBox.getPlaces();
        if (places.length == 0) return;

        const bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) return;
            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            marker.setIcon(icon);
            marker.setPosition(place.geometry.location);
            bounds.extend(place.geometry.location);
        });
        map.fitBounds(bounds);
    });

    // Adicionar evento de clique no botão de busca
    document.getElementById('search-button').addEventListener('click', function() {
        const address = addressInput.value.trim();
        if (address === '') return;

        geocodeAddress(address, map, marker);
    });

    // Função para atualizar o mapa com novos valores de latitude e longitude
    function updateMap(lat, lng) {
        map.setCenter(new google.maps.LatLng(lat, lng));
        marker.setPosition(new google.maps.LatLng(lat, lng));
    }
}

function geocodeAddress(address, map, marker) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                const latlng = results[0].geometry.location;
                marker.setPosition(latlng);
                map.setCenter(latlng);
                map.setZoom(15);
            } else {
                alert('Não foi possível encontrar resultados para essa localização.');
            }
        } else {
            alert('Geocoding falhou: ' + status);
        }
    });
}