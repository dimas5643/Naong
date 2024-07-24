<?php
include('./cabecalho.php');
include('consultas_ong.php');
include('consultas_departamento.php');

?>


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

            foreach ($listDepartamentoTodos as $departamento) {

            ?>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <a href="departamento.php?id=<?php echo $departamento['id_departamento']; ?>">
                        <div class="row-cols-1 feature-item p-4">
                            <div class="col-12 text-center">
                                <div class="feature-icon mb-4">
                                    <div class="p-3 d-inline-flex bg-white rounded">
                                        <img width="50" height="50" src="<?php echo $departamento['icon'] ?>" alt="shirt" />

                                    </div>
                                </div>
                                <div class="feature-content d-flex flex-column text-center">
                                    <h5 class="mb-4"><?php echo $departamento['nome_departamento'] ?></h5>
                                    <p class="mb-0"><?php echo $departamento['ativo'] == 'A' ? 'ATIVO' : 'INATIVO' ?></p>
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


<?php include('./rodape.php') ?>