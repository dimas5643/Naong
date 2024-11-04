<?php
include('./valida_login.php');
include('./valida_acesso_tela.php');
include('./cabecalho.php');
include('departamento_model.php');
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
                            $mensagem = 'Erro ao salvar!';
                            break;
                        case '3':
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
                        <p class="fs-4 text-uppercase text-primary">CADASTRO </p>
                        <h1 class="display-5 mb-4">DEPARTAMENTO</h1>
                        <form action="departamento_model.php" method="POST">
                            <input type="hidden" value="<?php echo isset($getDepartamento) ? $getDepartamento[0]['id_departamento'] : 0 ?>" name="id_departamento">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-12">
                                    <label for="">NOME</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent " name="nome" value="<?php echo isset($getDepartamento) ? $getDepartamento[0]['nome_departamento'] : '' ?>" placeholder="NOME">
                                </div>
                                <div class="col-xl-12">
                                    <label for="">URL DO ICON</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent " name="icon" value="<?php echo isset($getDepartamento) ? $getDepartamento[0]['icon'] : '' ?>" placeholder="URL">
                                </div>
                                <div class="col-xl-12 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" <?php
                                                                                                                if (!isset($getDepartamento[0]['ativo']) || $getDepartamento[0]['ativo'] == 'A') {
                                                                                                                    echo 'checked';
                                                                                                                }
                                                                                                                ?> name="ativo">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">ATIVO</label>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary  w-100 py-3 px-5">CADASTRAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('./rodape.php');
