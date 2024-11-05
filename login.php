<?php include('./cabecalho.php') ?>
<!-- Book Appointment Start -->


<div class="container-fluid appointment py-6">
    <div class="container py-12">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12" style="padding-top: 150px; padding-bottom: 50px;">
                <?php
                // Verifica se o usuário foi redirecionado do valida_login.php
                if (isset($_SESSION['login_redirect'])) {
                    // Exibe o alerta de login necessário
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Faça o login!</strong> para acessar a página.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    // Remove a variável de sessão para que o alerta não apareça novamente
                    unset($_SESSION['login_redirect']);
                }
                ?>
                <?php
                if (isset($_GET['erro'])) {
                    $mensagem = '';
                    switch ($_GET['erro']) {
                        case '1':
                            $mensagem = 'Preencha todos os dados!';
                            break;
                        case '2':
                            $mensagem = 'Email ou senha inválidos!';
                            break;
                        case '3':
                            $mensagem = 'Você não pode acessar essa página!';
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
                        <p class="fs-4 text-uppercase text-primary">Faça o Login</p>
                        <h1 class="display-5 mb-4">Login</h1>
                        <form action="processa_login.php" method="POST">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-12">
                                    <label for="">EMAIL</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent " name="email" placeholder="EMAIL">
                                </div>
                                <div class="col-xl-12">
                                    <label for="">SENHA</label>
                                    <input type="password" class="form-control py-3 border-primary bg-transparent" name="senha" placeholder="SENHA">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary  w-100 py-3 px-5">LOGIN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php include('./rodape.php') ?>