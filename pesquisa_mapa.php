<?php
include('./cabecalho.php');
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">MAPA</p>
                        <h1 class="display-5 mb-4">PESQUISAR NO MAPA</h1>
                        <form id="search-form" method="POST">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <label for="pesquisa">PESQUISAR</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white" id="pesquisa"
                                        name="pesquisa" placeholder="PESQUISAR">
                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary text-white w-100 py-3 px-5">PESQUISAR</button>
                                </div>
                            </div>
                        </form>
                        <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>
                        <div id="ong-list" style="
                            background-color: #f8f9fa; /* Cor de fundo clara */
                            border: 1px solid #dee2e6; /* Borda cinza clara */
                            border-radius: 8px; /* Bordas arredondadas */
                            padding: 20px; /* Espaço interno */
                            margin-top: 20px; /* Espaço acima */
                            max-height: 400px; /* Altura máxima para rolagem */
                            overflow-y: auto; /* Adiciona rolagem vertical se necessário */
                        ">
                            <!-- Lista de ONGs será exibida aqui -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-N9uCpQNAjSVptM-LjXOCmfS19UZiPhs&libraries=places&callback=initMap" async defer></script>
<script>
function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -28.681709540162558, lng: -49.37358875197284 },
        zoom: 15,  // Aumente este valor para um zoom mais próximo
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const geocoder = new google.maps.Geocoder();

    // Buscar as ONGs e adicionar marcadores e lista
    fetch('get_ongs.php')
        .then(response => response.json())
        .then(ongs => {
            const ongListContainer = document.getElementById('ong-list');
            ongListContainer.innerHTML = ''; // Limpa qualquer conteúdo existente

            ongs.forEach(ong => {
                const position = { lat: parseFloat(ong.latitude), lng: parseFloat(ong.longitude) };
                
                // Adicionar marcador
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: ong.nome_fantasia,
                    //icon: 'URL_DO_SEU_ICO'  // Substitua pela URL do seu ícone
                });

                // Adicionar infowindow com mais informações
                const infowindow = new google.maps.InfoWindow({
                    content: `<h5>${ong.nome_fantasia}</h5><p>${ong.endereco}</p>`
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });

                // Adicionar item à lista
                const listItem = document.createElement('div');
                listItem.className = 'ong-item';
                listItem.innerHTML = `<h5 style="margin: 0; font-size: 1.2em; color: #007bff;">${ong.nome_fantasia}</h5><p style="margin: 5px 0 0; font-size: 1em; color: #495057;">${ong.endereco}</p>`;
                listItem.style.backgroundColor = '#ffffff'; /* Cor de fundo branca para itens */
                listItem.style.borderBottom = '1px solid #dee2e6'; /* Borda inferior para separar os itens */
                listItem.style.padding = '15px'; /* Espaço interno dos itens */
                listItem.style.marginBottom = '10px'; /* Espaço entre os itens */
                listItem.style.borderRadius = '4px'; /* Bordas arredondadas dos itens */
                ongListContainer.appendChild(listItem);
            });
        })
        .catch(error => console.error('Erro ao carregar ONGs:', error));
}


function geocodeAddress(address, map) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                const latlng = results[0].geometry.location;
                map.setCenter(latlng);
                map.setZoom(12);  // Zoom adequado para mostrar a cidade

                // Filtrar ONGs próximas à localização centralizada
                filterOngsNearby(latlng, map);
            } else {
                alert('Não foi possível encontrar resultados para essa localização.');
            }
        } else {
            alert('Geocoding falhou: ' + status);
        }
    });
}

function filterOngsNearby(centerLatLng, map) {
    fetch('get_ongs.php')
        .then(response => response.json())
        .then(ongs => {
            const ongListContainer = document.getElementById('ong-list');
            ongListContainer.innerHTML = ''; // Limpa qualquer conteúdo existente

            const radiusInKm = 10; // Raio de 10 km

            ongs.forEach(ong => {
                const position = new google.maps.LatLng(parseFloat(ong.latitude), parseFloat(ong.longitude));
                const distance = google.maps.geometry.spherical.computeDistanceBetween(centerLatLng, position) / 1000;

                if (distance <= radiusInKm) {
                    // Adicionar marcador
                    const marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: ong.nome_fantasia,
                    });

                    // Adicionar infowindow com mais informações
                    const infowindow = new google.maps.InfoWindow({
                        content: `<h5>${ong.nome_fantasia}</h5><p>${ong.endereco}</p>`
                    });

                    marker.addListener('click', function() {
                        infowindow.open(map, marker);
                    });

                    // Adicionar item à lista
                    const listItem = document.createElement('div');
                    listItem.className = 'ong-item';
                    listItem.innerHTML = `<h5 style="margin: 0; font-size: 1.2em; color: #007bff;">${ong.nome_fantasia}</h5><p style="margin: 5px 0 0; font-size: 1em; color: #495057;">${ong.endereco}</p>`;
                    listItem.style.backgroundColor = '#ffffff'; /* Cor de fundo branca para itens */
                    listItem.style.borderBottom = '1px solid #dee2e6'; /* Borda inferior para separar os itens */
                    listItem.style.padding = '15px'; /* Espaço interno dos itens */
                    listItem.style.marginBottom = '10px'; /* Espaço entre os itens */
                    listItem.style.borderRadius = '4px'; /* Bordas arredondadas dos itens */
                    ongListContainer.appendChild(listItem);
                }
            });
        })
        .catch(error => console.error('Erro ao carregar ONGs:', error));
}


</script>

<?php
include('./rodape.php');
?>
