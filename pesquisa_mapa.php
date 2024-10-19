<?php
include('./cabecalho.php');
include('./pesquisa_mapa_model.php');

$departamentos = getDepartamentos();

// Verifica se a localização está disponível na sessão
$user_location = isset($_SESSION['user_location']) ? $_SESSION['user_location'] : null;
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
                            <input id="search-box" type="text" placeholder="Pesquisar local..." class="form-control py-2 mb-2" />
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

                        <button id="search-btn" class="btn btn-primary text-white w-100 py-3 px-5 mb-4">Atualizar Mapa</button>

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
    function initMap() {
        // showSpinner();

        const defaultLocation = {
            lat: -28.681709540162558,
            lng: -49.37358875197284
        };
        const userLocation = <?php echo $user_location ? json_encode($user_location) : 'null'; ?>;
        const mapCenter = userLocation || defaultLocation;

        const map = new google.maps.Map(document.getElementById('map'), {
            center: mapCenter,
            zoom: userLocation ? 12 : 8,
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

        // Geolocalização - captura a localização do usuário
        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition((position) => {
        //         const userLocation = {
        //             lat: position.coords.latitude,
        //             lng: position.coords.longitude
        //         };

        //         // Atualiza o mapa para o local do usuário
        //         map.setCenter(userLocation);
        //         map.setZoom(12);

        //         const geocoder = new google.maps.Geocoder();
        //         geocoder.geocode({
        //             location: userLocation
        //         }, (results, status) => {
        //             if (status === 'OK' && results[0]) {
        //                 let city = '';
        //                 let state = '';
        //                 let country = '';

        //                 results[0].address_components.forEach(component => {
        //                     const types = component.types;
        //                     if (types.includes('locality') || types.includes('sublocality') || types.includes('administrative_area_level_2')) {
        //                         city = component.long_name;
        //                     }
        //                     if (types.includes('administrative_area_level_1')) {
        //                         state = component.short_name;
        //                     }
        //                     if (types.includes('country')) {
        //                         country = component.long_name;
        //                     }
        //                 });

        //                 if (!city) {
        //                     city = 'Cidade não encontrada';
        //                 }

        //                 document.getElementById('search-box').value = `${city}, ${state}, ${country}`;

        //                 carregaMakers(userLocation.lat, userLocation.lng);

        //             } else {
        //                 alert('Não foi possível determinar sua localização.');
        //             }

        //             hideSpinner(); // Esconder o spinner depois da resposta da geolocalização

        //         });

        //     }, () => {
        //         alert('Erro: Não foi possível obter sua localização.');
        //         hideSpinner(); // Esconder o spinner em caso de erro
        //     });
        // } else {
        //     alert('Erro: Seu navegador não suporta geolocalização.');
        //     hideSpinner(); // Esconder o spinner se geolocalização não for suportada
        // }


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
