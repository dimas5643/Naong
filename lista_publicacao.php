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
        <?php foreach ($list_publicacoes as $key => $publicacoes) {
            // Criar o objeto DateTime a partir do formato 'Y-m-d H:i:s'
            $dataPublicacao = DateTime::createFromFormat('Y-m-d H:i:s', $publicacoes['dtpublicacao']);
            // Formatar a data para 'd-m-Y' ou outro formato desejado
            $dataFormatada = $dataPublicacao ? $dataPublicacao->format('d-m-Y') : '';

        ?>

            <div class="d-flex justify-content-center align-items-center text-center mb-4">

                <div class="card" style="width: 30rem;">
                    <a href="./cadastro_publicacao.php?id_publicacao=<?php echo $publicacoes['id_publicacoes'] ?>">
                        <div class="card-header d-flex justify-content-between">
                            <span class="text-left"><?php echo $publicacoes['nome_fantasia'] ?></span>
                            <span class="text-right"><?php echo $dataFormatada ?></span>
                        </div>
                        <img class="card-img-top" src="./<?php echo $publicacoes['arquivo'] ?>" alt="Card image cap" style="height: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $publicacoes['titulo'] ?></h5>
                            <p class="card-text"><?php echo $publicacoes['descricao'] ?></p>
                        </div>
                    </a>
                    <?php
                    $mensagemCompartilhamento = rawurlencode(
                        "Confira a publicação de " . $publicacoes['nome_fantasia'] . " 🌟 " . "\n\n" .
                            $publicacoes['titulo'] . "!\n\n" .  // Quebra de linha dupla
                            $publicacoes['descricao'] . "\n\n" .  // Outra quebra de linha entre descrição e o link
                            "Acesse a publicação: http://localhost/tcc/Naong/cadastro_publicacao.php?id_publicacao=" . $publicacoes['id_publicacoes']
                    );
                    ?>

                    <div class="card-footer text-muted" style="cursor: pointer;">
                        <a class="dropdown-item" href="https://api.whatsapp.com/send?text=<?php echo $mensagemCompartilhamento; ?>" target="_blank">
                            <i class="fa fa-whatsapp" aria-hidden="true"></i> Compartilhar no WhatsApp
                        </a>
                    </div>



                </div>

            </div>

            <hr>
        <?php } ?>
    </div>
</div>

<?php include('./rodape.php') ?>