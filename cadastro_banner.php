<?php
include('./cabecalho.php');
include './banco.php';
include ('./cadastro_banner_model.php');
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <div class="col-lg-12">
                            <p class="fs-4 text-uppercase text-primary">DADOS DO BANNER</p>
                            <?php if (!empty($row['arquivo'])) { ?>
                                <img src="<?php echo $row['arquivo']; ?>" alt="Foto de Perfil">
                            <?php } ?>
                        </div>

                        <form action="cadastro_banner_model.php" method="POST" enctype="multipart/form-data">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-4">
                                    <label for="">NOME</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome" placeholder="NOME" value="<?php echo isset($row['nome']) ? $row['nome'] : ''; ?>">
                                </div>
                                <div class="col-xl-4">
                                    <label for="">DATA INICIAL</label>
                                    <input type="datetime-local" class="form-control py-3 border-primary bg-transparent" name="dtinicial" placeholder="DATA INICIAL" value="<?php echo isset($row['dtinicial']) ? $row['dtinicial'] : ''; ?>">
                                </div>
                                <div class="col-xl-4">
                                    <label for="">DATA FINAL</label>
                                    <input type="datetime-local" class="form-control py-3 border-primary bg-transparent" name="dtfinal" placeholder="DATA FINAL" value="<?php echo isset($row['dtfinal']) ? $row['dtfinal'] : ''; ?>">
                                </div>

                                <div class="col-xl-12">
                                    <label for="">FOTO DE PERFIL</label>
                                    <input type="file" class="form-control py-3 border-primary bg-transparent" name="banner">
                                </div>

                                <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">CADASTRAR</button>

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
?>