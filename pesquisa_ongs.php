<?php
include('./cabecalho.php');
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">PESQUISA</p>
                        <h1 class="display-5 mb-4">DE ONGS</h1>
                        <form action="pesquisa_ongs_model.php" method="GET">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-4">
                                    <label for="nome">NOME DA ONG</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome_fantasia" placeholder="NOME DA ONG">
                                </div>
                                <div class="col-xl-4">
                                    <label for="endereco">ENDEREÇO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="endereco" placeholder="ENDEREÇO">
                                </div>
                                <div class="col-xl-4">
                                    <label for="estado">ESTADO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="estado" placeholder="ESTADO">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">PESQUISAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-12 mt-4">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>NOME DA ONG</th>
                                <th>ENDEREÇO</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($ongs) && !empty($ongs)) {
                                foreach ($ongs as $ong) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($ong['nome']) . "</td>";
                                    echo "<td>" . htmlspecialchars($ong['endereco']) . "</td>";
                                    echo "<td>" . htmlspecialchars($ong['estado']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Nenhuma ONG encontrada.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./rodape.php');
?>
