<?php
include('./cabecalho.php');
include('pesquisa_mapa_model.php');
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
                                        name="pesquisa" placeholder="PESQUISA">
                                </div>

                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary text-white w-100 py-3 px-5">PESQUISAR</button>
                                </div>
                            </div>
                        </form>
                        <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-N9uCpQNAjSVptM-LjXOCmfS19UZiPhs&callback=initMap" async
    defer></script>
<script>
let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: -23.5505,
            lng: -46.6333
        }, // Coordenadas iniciais (São Paulo, por exemplo)
        zoom: 8,
    });
}

document.getElementById("search-form").addEventListener("submit", function(event) {
    event.preventDefault();
    const address = document.getElementById("pesquisa").value;
    fetchAddresses(address);
});

function fetchAddresses(term) {
    fetch('./pesquisa_model.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'pesquisa': term
            })
        })
        .then(response => response.json())
        .then(enderecos => {
            clearMarkers();
            enderecos.forEach(endereco => {
                geocodeAddress(endereco);
            });
        })
        .catch(error => console.error('Erro:', error));
}

function geocodeAddress(address) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        address: address
    }, function(results, status) {
        if (status === "OK") {
            new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
            });
        } else {
            console.error("Geocode não foi bem-sucedido: " + status);
        }
    });
}

let markers = [];

function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}
</script>


<?php
include('./rodape.php');
?>