<?php
include('./valida_login.php');
include('./valida_acesso_tela.php');
include('./cabecalho.php');
include('./lista_registro_doacao_model.php');
?>
<div class="container-fluid feature py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">DOAÇÕES</h4>
            </div>
        </div>
        <?php foreach ($list_registros as $key => $registros) {
            // Criar o objeto DateTime a partir do formato 'Y-m-d H:i:s'
            $dataPublicacao = DateTime::createFromFormat('Y-m-d H:i:s', $registros['data_doacao']);
            // Formatar a data para 'd-m-Y' ou outro formato desejado
            $dataFormatada = $dataPublicacao ? $dataPublicacao->format('d-m-Y H:i:s') : '';

        ?>

            <div class="d-flex justify-content-center align-items-center text-center mb-4">
                <a href="./cadastro_registro_doacao.php?id_registro=<?php echo $registros['id_registro'] ?>">
                    <div class="card text-center" style="width: 50rem;">
                        <div class="card-header">
                            <?php echo $registros['nome_fantasia'] ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $registros['doacao'] ?></h5>
                        </div>
                        <div class="card-footer text-body-secondary">
                            <?php echo $dataFormatada ?>
                        </div>
                    </div>
                </a>
            </div>



            <hr>
        <?php } ?>
    </div>
</div>

<?php include('./rodape.php') ?>