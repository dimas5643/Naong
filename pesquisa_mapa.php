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

                        <!-- Input de pesquisa e botão -->
                        <div id="map-controls">
                            <input id="search-box" type="text" placeholder="Pesquisar local..." class="form-control py-2" style="margin-bottom: 10px;" />
                            <button id="search-btn" class="btn btn-primary text-white w-100 py-3 px-5" style="margin-bottom: 20px;">Atualizar Mapa</button>
                        </div>

                        <!-- Mapa -->
                        <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>

                        <!-- Lista de ONGs -->
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
            center: {
                lat: -28.681709540162558,
                lng: -49.37358875197284
            },
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Configurar SearchBox e botão de pesquisa
        const searchBox = new google.maps.places.SearchBox(document.getElementById('search-box'));
        const searchBtn = document.getElementById('search-btn');

        // Função para calcular a distância entre dois pontos (em km)
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // Raio da Terra em km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        // Evento para atualizar o mapa ao clicar no botão de pesquisa
        searchBtn.addEventListener('click', () => {
            const places = searchBox.getPlaces();
            if (!places || places.length === 0) {
                alert('Nenhum lugar encontrado.');
                return;
            }

            const bounds = new google.maps.LatLngBounds();
            const place = places[0];

            if (place.geometry) {
                map.setCenter(place.geometry.location);
                map.setZoom(14);

                // Buscar as ONGs e adicionar marcadores e lista filtrada
                fetch('get_ongs.php')
                    .then(response => response.json())
                    .then(ongs => {
                        const ongListContainer = document.getElementById('ong-list');
                        ongListContainer.innerHTML = ''; // Limpa qualquer conteúdo existente
                        const markers = [];

                        // Filtrar ONGs mais próximas (dentro de 10 km)
                        const nearbyOngs = ongs.filter(ong => {
                            const distance = calculateDistance(
                                place.geometry.location.lat(),
                                place.geometry.location.lng(),
                                parseFloat(ong.latitude),
                                parseFloat(ong.longitude)
                            );
                            return distance <= 10; // ONGs dentro de um raio de 10 km
                        });

                        nearbyOngs.forEach(ong => {
                            const position = {
                                lat: parseFloat(ong.latitude),
                                lng: parseFloat(ong.longitude)
                            };

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

                            markers.push(marker);

                            // Adicionar item à lista e adicionar um link para o perfil da ONG
                            const listItem = document.createElement('div');
                            listItem.className = 'ong-item';
                            console.log(ong);
                            listItem.innerHTML = `
                            <a href="perfil_ong.php?id_ong=${ong.id_ong}" style="text-decoration: none; color: inherit;">
                                <h5 style="margin: 0; font-size: 1.2em; color: #007bff;">${ong.nome_fantasia}</h5>
                                <p style="margin: 5px 0 0; font-size: 1em; color: #495057;">${ong.endereco}</p>
                            </a>`;
                            listItem.style.backgroundColor = '#ffffff'; /* Cor de fundo branca para itens */
                            listItem.style.borderBottom = '1px solid #dee2e6'; /* Borda inferior para separar os itens */
                            listItem.style.padding = '15px'; /* Espaço interno dos itens */
                            listItem.style.marginBottom = '10px'; /* Espaço entre os itens */
                            listItem.style.borderRadius = '4px'; /* Bordas arredondadas dos itens */
                            ongListContainer.appendChild(listItem);
                        });

                        if (nearbyOngs.length === 0) {
                            ongListContainer.innerHTML = '<p>Nenhuma ONG encontrada próxima a esse local.</p>';
                        }
                    })
                    .catch(error => console.error('Erro ao carregar ONGs:', error));
            }
        });
    }
</script>

<?php
include('./rodape.php');
?>