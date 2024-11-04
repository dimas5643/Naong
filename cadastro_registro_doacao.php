<?php
include('./valida_login.php');
include('./valida_acesso_tela.php');
include('./cabecalho.php');
include('./cadastro_registro_doacao_model.php');
include './banco.php';
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <?php
                if (isset($_GET['erro'])) {
                    $mensagem = '';
                    switch ($_GET['erro']) {
                        case '1':
                            $mensagem = 'Preencha todos os dados!';
                            break;
                        case '2':
                            $mensagem = 'Você não tem permissão para excluir essa publicação!';
                            break;
                        case '3':
                            $mensagem = 'Erro ao salvar!';
                            break;
                        case '4':
                            $mensagem = 'Nenhum registro encontrado!';
                            break;
                        default:
                            $mensagem = 'Erro desconhecido!';
                            break;
                    }

                    if ($mensagem) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $mensagem; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php }
                }
                ?>
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">DADOS DO REGISTRO</p>
                        <h1 class="display-5 mb-4">REGISTROS</h1>
                        <form action="cadastro_registro_doacao_model.php" method="POST" enctype="multipart/form-data">
                            <?php if (isset($row['id_registro'])) { ?>
                                <input type="hidden" name="id_registro" value="<?php echo $row['id_registro'] ?>">
                            <?php } ?>

                            <div class="row gy-3 gx-4">
                                <div class="col-xl-12">
                                    <label for="">DESCRIÇÃO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent " name="doacao" placeholder="DESCRIÇÃO" value="<?php echo isset($row['doacao']) ? $row['doacao'] : ''; ?>">
                                </div>

                                <div class="col-xl-12">
                                    <label for="">DATA</label>
                                    <input type="datetime-local" class="form-control py-3 border-primary bg-transparent " name="data" placeholder="data" value="<?php echo isset($row['data_doacao']) ? $row['data_doacao'] : ''; ?>">
                                </div>

                                <div class="col-xl-12">
                                    <label for="">VALOR DOADO (R$)</label>
                                    <input type="text" id="valor" class="form-control py-3 border-primary bg-transparent " name="valor" placeholder="0,00" value="<?php echo isset($row['valor']) ? number_format($row['valor'], 2, ',', '.') : ''; ?>">
                                </div>

                                <div class="col-xl-12">
                                    <label for="">ONG</label>
                                    <select class="form-control py-3 border-primary bg-transparent" name="ong">
                                        <option value=""></option>
                                        <?php foreach ($list_ongs as $ongs) { ?>
                                            <option value="<?php echo $ongs['id_ong']; ?>" <?php if (isset($row['id_ong'])) {
                                                                                                echo $row['id_ong'] == $ongs['id_ong'] ? 'selected' : '';
                                                                                            } ?>><?php echo $ongs['nome_fantasia']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary  w-100 py-3 px-5" style="margin-top: 15px;">SALVAR</button>
                            <?php if (isset($row)) { ?>
                                <button type="submit" name="acao" value="excluir" class="btn btn-danger  w-100 py-3 px-5" style="margin-top: 15px;">EXCLUIR</button>
                            <?php } ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./rodape.php');
?>

<script>
    document.getElementById('valor').addEventListener('input', function(e) {
        let value = e.target.value;
        value = value.replace(/\D/g, '');
        value = (value / 100).toFixed(2) + '';
        value = value.replace('.', ',');
        value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        e.target.value = value;
    });
</script>