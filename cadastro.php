<?php include('./cabecalho.php') ?>
<!-- Book Appointment Start -->
<div class="container-fluid appointment py-12">
    <div class="container py-12" >
        <div class="row g-12 align-items-center">


            <div class="col-lg-6">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">Faça o Login</p>
                        <h1 class="display-5 mb-4">Login</h1>
                        <form action="processa_login.php" method="POST">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-12">
                                    <label for="">EMAIL</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="email" placeholder="EMAIL">
                                </div>
                                <div class="col-xl-12">
                                    <label for="">SENHA</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent" name="senha" placeholder="SENHA">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">LOGIN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6"  style="padding-top: 150px; padding-bottom: 50px;">
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
                                        <!-- <div class="col-xl-6">
                                        <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                            <option selected>Your Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">FeMale</option>
                                            <option value="3">Others</option>
                                        </select>
                                    </div> -->
                                        <div class="col-xl-6">
                                            <label for="">DATA DE NASCIMENTO</label>
                                            <input type="date" class="form-control py-3 border-primary bg-transparent" name="data_nascimento">
                                        </div>
                                        <!-- <div class="col-xl-6">
                                        <select class="form-select py-3 border-primary bg-transparent" aria-label="Default select example">
                                            <option selected>Department</option>
                                            <option value="1">Physiotherapy</option>
                                            <option value="2">Physical Helth</option>
                                            <option value="2">Treatments</option>
                                        </select>
                                    </div> -->
                                        <!-- <div class="col-12">
                                        <textarea class="form-control border-primary bg-transparent text-white" name="text" id="area-text" cols="30" rows="5" placeholder="Write Comments"></textarea>
                                    </div> -->
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



<?php include('./rodape.php') ?>