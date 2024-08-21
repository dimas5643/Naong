<?php
include('./cabecalho.php');
include('./lista_publicacao_model.php');
?>
<div class="container-fluid feature py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">PUBLICAÇÕES</h4>
            </div>
        </div>
        <!-- Adicionando a classe d-flex para criar um flexbox container -->
        <?php foreach ($list_publicacoes as $key => $publicacoes) { ?>

            <div class="d-flex justify-content-center align-items-center text-center">
                <a href="./cadastro_publicacao.php?id_publicacao=<?php echo $publicacoes['id_publicacoes'] ?>">
                    <div class="card" style="width: 30rem;">
                        <img class="card-img-top" src="./<?php echo $publicacoes['arquivo'] ?>" alt="Card image cap" style=" height: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $publicacoes['titulo'] ?></h5>
                            <p class="card-text"><?php echo $publicacoes['descricao'] ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <hr>
        <?php } ?>
    </div>
</div>

<?php include('./rodape.php') ?>