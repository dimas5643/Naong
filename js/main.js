(function ($) {
    "use strict";

    // Mostrar o spinner
    function showSpinner() {
        $('#spinner').addClass('show');
    }

    // Esconder o spinner
    function hideSpinner() {
        $('#spinner').removeClass('show');
    }

    // Função para salvar localização no backend
    function saveLocationToSession(locationData) {
        fetch('./save_location.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },  
            body: JSON.stringify(locationData)
        }).then(response => response.json())
          .then(data => {
              console.log('Localização salva na sessão:', data);
          }).catch(error => {
              console.error('Erro ao salvar localização:', error);
          });
    }

    // Função para obter cidade, estado e país
    function geocodeLatLng(lat, lng) {
        const geocoder = new google.maps.Geocoder();
        const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };

        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === 'OK') {
                if (results[0]) {
                    let city = '';
                    let state = '';
                    let country = '';

                    results[0].address_components.forEach(component => {
                        const types = component.types;
                        if (types.includes('locality') || types.includes('sublocality') || types.includes('administrative_area_level_2')) {
                            city = component.long_name;
                        }
                        if (types.includes('administrative_area_level_1')) {
                            state = component.short_name;
                        }
                        if (types.includes('country')) {
                            country = component.long_name;
                        }
                    });

                    // Salva na sessão os dados de localização
                    saveLocationToSession({
                        city: city,
                        state: state,
                        country: country,
                        latitude: lat,
                        longitude: lng
                    });
                } else {
                    console.log('Nenhum resultado encontrado');
                }
            } else {
                console.log('Geocoder falhou: ' + status);
            }
        });
    }

    // Função para capturar a localização do usuário
    function captureUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Geocode para obter cidade, estado e país
                geocodeLatLng(userLocation.lat, userLocation.lng);

            }, () => {
                console.log('Erro: Não foi possível obter sua localização.');
            });
        } else {
            console.log('Erro: Seu navegador não suporta geolocalização.');
        }
    }

    // Chamar a função ao carregar a página
    $(document).ready(function () {
        captureUserLocation();
    });
    



    
    // Expor as funções de spinner globalmente para outros scripts
    window.showSpinner = showSpinner;
    window.hideSpinner = hideSpinner;

        // Executar a lógica quando a página estiver pronta
        $(document).ready(function () {
            setTimeout(function () {
                if ($('#spinner').length > 0) {
                    // Verifica se estamos na página de pesquisa_mapa.php
                    // if (window.location.pathname.includes('pesquisa_mapa.php')) {
                        // Não esconder o spinner nesta página
                        // return; 
                    // }
                    hideSpinner(); // Só oculta manualmente quando for necessário
                }
            }, 1000);
        });
        
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });


    // Hero Header carousel
    $(".header-carousel").owlCarousel({
        animateOut: 'slideOutDown',
        items: 1,
        autoplay: true,
        smartSpeed: 1000,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
    });


    // International carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        items: 1,
        smartSpeed: 1500,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });


    // testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:1
            },
            1200:{
                items:1
            }
        }
    });

    
    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

    


})(jQuery);
