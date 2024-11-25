<?php
include('./cabecalho.php');
include('./pesquisa_mapa_model.php');

$departamentos = getDepartamentos();


$userLocation = '';
if (isset($_SESSION['location'])) {
    $userLocation = $_SESSION['location']['city'] . ', ' . $_SESSION['location']['state'] . ', ' . $_SESSION['location']['country'];
}
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">MAPA</p>
                        <h1 class="display-5 mb-4">PESQUISAR NO MAPA</h1>

                        <!-- Input de pesquisa e botão -->
                        <div id="map-controls" class="mb-4">
                            <label class="form-label">Digite o local</label>
                            <input id="search-box" type="text" value="<?php echo htmlspecialchars($userLocation); ?>" placeholder="Pesquisar local..." class="form-control py-2 mb-2" />
                        </div>

                        <!-- Filtro de Departamento -->
                        <div class="form-group mb-4">
                            <label for="departamento" class="form-label">Selecione o Departamento</label>
                            <select id="departamento" class="form-control">
                                <option value="">Todos os Departamentos</option>
                                <?php foreach ($departamentos as $departamento) { ?>
                                    <option value="<?php echo $departamento['id_departamento']; ?>" <?php echo $get_departamento ==  $departamento['id_departamento'] ? 'selected' : '' ?>>
                                        <?php echo $departamento['nome_departamento']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <button id="search-btn" class="btn btn-primary text-white w-100 py-3 px-5 mb-4" onclick="initMap()">Atualizar Mapa</button>

                        <!-- Mapa -->
                        <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>

                        <!-- Lista de ONGs -->
                        <div id="ong-list" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-top: 20px; max-height: 400px; overflow-y: auto;">
                            <!-- Lista de ONGs será exibida aqui -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./rodape.php'); ?>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-N9uCpQNAjSVptM-LjXOCmfS19UZiPhs&libraries=places&callback=initMap" async defer></script> -->

<script>
    $(document).ready(function() {
        <?php if (isset($_SESSION['location'])) { ?>
            userLatitude = <?php echo (float)$_SESSION['location']['latitude']; ?>;
            userLongitude = <?php echo (float)$_SESSION['location']['longitude']; ?>;
        <?php } else { ?>
            userLatitude = -28.681709540162558;
            userLongitude = -49.37358875197284;
        <?php } ?>

        initMap(userLatitude, userLongitude);
    });

    document.getElementById('search-btn').addEventListener('click', function() {
        const address = document.getElementById('search-box').value;

        if (!address) {
            alert('Por favor, insira um local válido para pesquisar.');
            return;
        }

        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({
            address: address
        }, function(results, status) {
            if (status === 'OK') {
                const location = results[0].geometry.location;
                const lat = location.lat();
                const lng = location.lng();

                // Chama a função para carregar os marcadores de ONGs
                initMap(lat, lng);
            } else {
                alert('Geocodificação falhou: ' + status);
            }
        });
    });


    function initMap(userLatitude, userLongitude) {


        const map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: userLatitude,
                lng: userLongitude
            },
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        let markers = [];
        const searchBox = new google.maps.places.SearchBox(document.getElementById('search-box'));



        // Função para remover todos os marcadores do mapa
        function clearMarkers() {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null); // Remove o marcador do mapa
            }
            markers = []; // Limpa o array de marcadores
        }


        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();

            if (places.length === 0) {
                alert('Nenhum lugar encontrado.');
                return;
            }

            const place = places[0];

            if (!place.geometry) {
                alert('O local selecionado não tem geometria.');
                return;
            }

            map.setCenter(place.geometry.location);
            map.setZoom(14);

            carregaMakers(place.geometry.location.lat(), place.geometry.location.lng());
        });

        // Função para carregar os marcadores de ONGs
        function carregaMakers(lat, lng) {
            const departamentoId = document.getElementById('departamento').value;

            clearMarkers();

            fetch('get_ongs.php')
                .then(response => response.json())
                .then(ongs => {
                    const ongListContainer = document.getElementById('ong-list');
                    ongListContainer.innerHTML = '';

                    const nearbyOngs = ongs.filter(ong => {
                        const distance = calculateDistance(
                            lat, lng,
                            parseFloat(ong.latitude),
                            parseFloat(ong.longitude)
                        );

                        const isInDepartment = departamentoId === "" || ong.id_departamento == departamentoId;

                        return distance <= 10 && isInDepartment;
                    });

                    nearbyOngs.forEach(ong => {
                        const position = {
                            lat: parseFloat(ong.latitude),
                            lng: parseFloat(ong.longitude)
                        };

                        const marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: ong.nome_fantasia,
                        });

                        const infowindow = new google.maps.InfoWindow({
                            content: `<h5>${ong.nome_fantasia}</h5><p>${ong.endereco}</p>`
                        });

                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });

                        markers.push(marker);

                        const listItem = document.createElement('div');
                        listItem.className = 'ong-item';
                        listItem.innerHTML = `
                        <a href="perfil_ong.php?id_ong=${ong.id_ong}" style="text-decoration: none; color: inherit;">
                            <h5 style="margin: 0; font-size: 1.2em; color: #007bff;">${ong.nome_fantasia}</h5>
                            <p style="margin: 5px 0 0; font-size: 1em; color: #495057;">${ong.endereco}</p>
                        </a>`;
                        listItem.style.backgroundColor = '#ffffff';
                        listItem.style.borderBottom = '1px solid #dee2e6';
                        listItem.style.padding = '15px';
                        listItem.style.marginBottom = '10px';
                        listItem.style.borderRadius = '4px';
                        ongListContainer.appendChild(listItem);
                    });

                    if (nearbyOngs.length === 0) {
                        ongListContainer.innerHTML = '<p>Nenhuma ONG encontrada próxima a esse local e com o departamento selecionado.</p>';
                    }

                    // Esconde o spinner quando terminar de carregar
                    hideSpinner();
                })
                .catch(error => {
                    console.error('Erro ao carregar ONGs:', error);
                    hideSpinner();
                });
        }

        carregaMakers(userLatitude, userLongitude);

        // Função para calcular a distância entre dois pontos (em km)
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }
    }
</script>