<?php
include('./valida_login.php');
include('./valida_acesso_tela.php');
include('./cabecalho.php');
include('coleta_model.php');
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
                            $mensagem = 'Esse ponto de coleta já está vinculado a uma publicação. Em vez de excluí-lo, inative-o para manter o histórico!';
                            break;
                        case '3':
                            $mensagem = 'Você não tem permissão para excluir essa publicação!';
                            break;
                        case '4':
                            $mensagem = 'Erro ao salvar!';
                            break;
                        case '5':
                            $mensagem = 'Usuário inválido!';
                            break;
                        case '6':
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
                        <p class="fs-4 text-uppercase text-primary">CADASTRO PONTO DE COLETA </p>
                        <h1 class="display-5 mb-4">PONTO DE COLETA</h1>
                        <form action="coleta_model.php" method="POST">
                            <?php if (isset($row_pontos_coleta['id'])) { ?>
                                <input type="hidden" name="id_pontos_coleta" value="<?php echo $row_pontos_coleta['id'] ?>">
                            <?php } ?>
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <label for="">NOME</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome" placeholder="NOME" value="<?php echo isset($row_pontos_coleta['nome']) ? $row_pontos_coleta['nome'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">RUA</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white" name="rua"
                                        placeholder="RUA" value="<?php echo isset($row_pontos_coleta['rua']) ? $row_pontos_coleta['rua'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CIDADE</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white" name="cidade"
                                        placeholder="CIDADE" value="<?php echo isset($row_pontos_coleta['cidade']) ? $row_pontos_coleta['cidade'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">ESTADO</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white" name="estado"
                                        placeholder="ESTADO" value="<?php echo isset($row_pontos_coleta['estado']) ? $row_pontos_coleta['estado'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CEP</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white" name="cep"
                                        placeholder="CEP" value="<?php echo isset($row_pontos_coleta['cep']) ? $row_pontos_coleta['cep'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">PAIS</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white" name="pais"
                                        placeholder="PAIS" value="<?php echo isset($row_pontos_coleta['pais']) ? $row_pontos_coleta['pais'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">NUMERO ENDEREÇO</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent text-white"
                                        name="numero_endereco" placeholder="NUMERO ENDEREÇO" value="<?php echo isset($row_pontos_coleta['numero_endereco']) ? $row_pontos_coleta['numero_endereco'] : '' ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">TELEFONE</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent"
                                        name="telefone" placeholder="TELEFONE" value="<?php echo isset($row_pontos_coleta['telefone']) ? $row_pontos_coleta['telefone'] : '' ?>">
                                </div>
                                <!-- ativo -->
                                <div class="col-xl-6">
                                    <label for="ativo-checkbox">ATIVO</label>
                                    <input type="checkbox" id="ativo-checkbox" class="form-check-input border-primary bg-transparent" name="ativo" <?php if ((isset($row_pontos_coleta['ativo']) && $row_pontos_coleta['ativo'] == 'A') || !isset($row_pontos_coleta)) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    }  ?>>
                                </div>


                                <div class="col-12">
                                    <?php if (!isset($row_pontos_coleta)) { ?>
                                        <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">CADASTRAR</button>
                                    <?php } else  if (isset($row_pontos_coleta)) { ?>
                                        <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">ATUALIZAR</button>
                                        <button type="submit" name="acao" value="excluir" class="btn btn-danger text-white w-100 py-3 px-5" style="margin-top: 15px;">EXCLUIR</button>
                                    <?php } ?>
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
