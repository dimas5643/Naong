<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5 text-center">
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-white mb-4"><i class="fas fa-star-of-life me-3"></i>NaOng</h4>
                    <p>Contribua para transformar vidas! Todas as doações realizadas por meio deste site são destinadas diretamente às ONGs, ajudando a promover ações sociais e ambientais. Juntos, podemos construir um futuro melhor. Sua solidariedade faz a diferença!
                    </p>
                    <!-- <div class="d-flex align-items-center">
                        <i class="fas fa-share fa-2x text-white me-2"></i>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div> -->
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Links Rápidos</h4>
                    <a href="index.php"> Home </a>
                    <a href="login.php"> Login </a>
                    <a href="cadastro.php"> Cadastro </a>
                    <a href="pesquisa_mapa.php">Pesquisa Ongs</a>
                    <a href="lista_publicacao.php">Publicações</a>
                </div>
            </div>

            <!-- <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Terapia Services</h4>
                    <a href=""><i class="fas fa-angle-right me-2"></i> All Services</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Physiotherapy</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Diagnostics</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Manual Therapy</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Massage Therapy</a>
                    <a href=""><i class="fas fa-angle-right me-2"></i> Rehabilitation</a>
                </div>
            </div> -->
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Contatos</h4>
                    <!-- <a href=""><i class="fa fa-map-marker-alt me-2"></i> 123 Street, New York, USA</a> -->
                    <!-- <a href=""><i class="fas fa-envelope me-2"></i> info@example.com</a> -->
                    <a href=""><i class="fa fa-envelope me-2"></i> naong@naong.com</a>
                    <a href=""><i class="fa fa-phone me-2"></i> +55 (48) 99608-3890 </a>
                    <a href=""><i class="fa fa-globe me-2"></i> www.naong.com </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center text-md-start mb-md-0">
                <span class="text-white"><a href="#"><i class="fas fa-copyright text-light me-2"></i>NaOng</a>, Todos os direitos reservados</span>
            </div>
            <div class="col-md-6 text-center text-md-end text-white">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->


<div id="alert-container"></div>
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js">
    function mensagemErro(text) {
        const alertHTML = `
                        <div class="alert alert-danger  " role="alert">
                            ${text}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;

        const alertContainer = document.getElementById("alert-container");
        alertContainer.innerHTML = alertHTML;
    }
</script>
</body>

</html>