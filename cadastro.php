<?php include('./cabecalho.php') ?>
<!-- Book Appointment Start -->
<div class="container-fluid appointment py-12">
    <div class="container py-12">
        <div class="row g-12 align-items-center">
            <div class="col-sm-12" style="padding-top: 150px; padding-bottom: 50px;">
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
                            $mensagem = 'Erro ao salvar o endereço, tente novamente!';
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
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-doador-tab" data-bs-toggle="pill" data-bs-target="#pills-doador" type="button" role="tab" aria-controls="pills-doador" aria-selected="true">Doador</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-ong-tab" data-bs-toggle="pill" data-bs-target="#pills-ong" type="button" role="tab" aria-controls="pills-ong" aria-selected="false">ONG</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-doador" role="tabpanel" aria-labelledby="pills-doador-tab">
                        <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                            <div class="appointment-form rounded p-5">
                                <p class="fs-4 text-uppercase text-primary">Preencha o formulario</p>
                                <h1 class="display-5 mb-4">Cadastro de Doador</h1>
                                <form action="doador_model.php" method="POST">
                                    <div class="row gy-3 gx-4">
                                        <div class="col-xl-6">
                                            <label for="">NOME</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome" placeholder="NOME">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">DOCUMENTO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="documento" placeholder="CPF/CNPJ">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CEP</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="cep" placeholder="CEP">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">ESTADO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="estado" placeholder="ESTADO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CIDADE</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="cidade" placeholder="CIDADE">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">ENDEREÇO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="endereco" placeholder="ENDEREÇO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CONTATO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent" name="celular" placeholder="CONTATO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">EMAIL</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="email" placeholder="EMAIL">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">SENHA</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent" name="senha" placeholder="SENHA">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">DATA DE NASCIMENTO</label>
                                            <input type="date" class="form-control py-3 border-primary bg-transparent" name="data_nascimento">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">CADASTRAR</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-ong" role="tabpanel" aria-labelledby="pills-ong-tab">
                        <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                            <div class="appointment-form rounded p-5">
                                <p class="fs-4 text-uppercase text-primary">Preencha o formulario</p>
                                <h1 class="display-5 mb-4">Cadastro de ONG</h1>
                                <form action="ong_model.php" method="POST">
                                    <div class="row gy-3 gx-4">
                                        <div class="col-xl-6">
                                            <label for="">NOME</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome" placeholder="NOME">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">DOCUMENTO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="documento" placeholder="DOCUMENTO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CEP</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="cep" placeholder="CEP">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">ESTADO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="estado" placeholder="ESTADO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CIDADE</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="cidade" placeholder="CIDADE">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">ENDEREÇO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="endereco" placeholder="ENDEREÇO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CONTATO</label>
                                            <input type="phone" class="form-control py-3 border-primary bg-transparent" name="contato" placeholder="CONTATO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">EMAIL</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="email" placeholder="EMAIL">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">SENHA</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent" name="senha" placeholder="SENHA">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">CADASTRAR</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('./rodape.php') ?>