    <?php
    include('./cabecalho.php');
    include('consultas_ong.php');
    include('consultas_departamento.php');
    include('consultas_publicacoes.php');
    include('consultas_banners.php');

    ?>

    <!-- Carousel Start -->
    <div class="header-carousel owl-carousel">
        <?php foreach ($list_banners as $key => $banners) { ?>
            <div class="header-carousel-item">
                <img src="<?php echo $banners['arquivo'] ?>" class="img-fluid w-100" alt="Image">
            </div>
        <?php } ?>

    </div>
    <!-- Carousel End -->



    <!-- Services Start -->
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">ONGS</h4>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <?php
                foreach ($listOngs as $ong) {
                ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded">
                            <div class="service-img rounded-top">
                                <img src="img/service-1.jpg" class="img-fluid rounded-top w-100" alt="">
                            </div>
                            <div class="service-content rounded-bottom bg-light p-4">
                                <div class="service-content-inner">
                                    <h5 class="mb-4"><?php echo $ong['nome_fantasia']; ?></h5>
                                    <p class="mb-4"><?php echo $ong['endereco']; ?></p>
                                    <a href="perfil_ong.php?id_ong=<?php echo $ong['id_ong']; ?>" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Leia Mais</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Services End -->


    <!-- About Start -->
    <!-- <div class="container-fluid about bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-img pb-5 ps-5">
                        <img src="img/about-1.jpg" class="img-fluid rounded w-100" style="object-fit: cover;" alt="Image">
                        <div class="about-img-inner">
                            <img src="img/about-2.jpg" class="img-fluid rounded-circle w-100 h-100" alt="Image">
                        </div>
                        <div class="about-experience">15 years experience</div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="section-title text-start mb-5">
                        <h4 class="sub-title pe-3 mb-0">About Us</h4>
                        <h1 class="display-3 mb-4">We are Ready to Help Improve Your Treatment.</h1>
                        <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
                        <div class="mb-4">
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Refresing to get such a personal touch.</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Duis aute irure dolor in reprehenderit in voluptate.</p>
                            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- About End -->

    <!-- Feature Start -->
    <div class="container-fluid feature py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">DEPARTAMENTOS</h4>
                </div>
                <!-- <h1 class="display-3 mb-4">Why Choose Us? Get Your Life Style Back</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p> -->
            </div>
            <div class="row g-4 justify-content-center">

                <?php

                foreach ($listDepartamentoAtivos as $departamento) {

                ?>

                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="pesquisa_mapa.php?id_departamento=<?php echo $departamento['id_departamento'] ?>">
                            <div class="row-cols-1 feature-item p-4">
                                <div class="col-12 text-center">
                                    <div class="feature-icon mb-4">
                                        <div class="p-3 d-inline-flex bg-white rounded">
                                            <img width="50" height="50" src="<?php echo $departamento['icon'] ?>" alt="shirt" />

                                        </div>
                                    </div>
                                    <div class="feature-content d-flex flex-column text-center">
                                        <h5 class="mb-4"><?php echo $departamento['nome_departamento'] ?></h5>
                                        <!-- <p class="mb-0">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus,</p> -->
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Feature End -->




    <!-- Modal Video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Book Appointment End -->


    <!-- Blog Start -->
    <div class="container-fluid blog py-5">
        <div class="container py-5">
            <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="sub-style">
                    <h4 class="sub-title px-3 mb-0">PUBLICAÇÕES</h4>
                </div>
                <!-- <h1 class="display-3 mb-4">Excellent Facility and High Quality Therapy</h1>
                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p> -->
            </div>
            <div class="card-group">
                <?php foreach ($list_publicacoes as $key => $publicacoes) {
                    // Criar o objeto DateTime a partir do formato 'Y-m-d H:i:s'
                    $dataPublicacao = DateTime::createFromFormat('Y-m-d H:i:s', $publicacoes['dtpublicacao']);
                    // Formatar a data para 'd-m-Y' ou outro formato desejado
                    $dataFormatada = $dataPublicacao ? $dataPublicacao->format('d-m-Y') : '';
                ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card text-center">
                            <a href="./cadastro_publicacao.php?id_publicacao=<?php echo $publicacoes['id_publicacoes'] ?>" >
                                <img src="./<?php echo $publicacoes['arquivo'] ?>" class="card-img-top img-fluid" style="height: 350px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $publicacoes['titulo'] ?></h5>
                                    <p class="card-text"><?php echo $publicacoes['descricao'] ?></p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-body-secondary d-flex justify-content-between">
                                        <span class="text-left"><?php echo $publicacoes['nome_fantasia'] ?></span>
                                        <span class="text-right"><?php echo $dataFormatada ?></span></small>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
    <!-- Blog End -->

    <?php include('./rodape.php') ?>