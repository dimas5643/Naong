<?php
include('./cabecalho.php');
include('pesquisa_ongs_model.php'); // Inclua o model para obter os resultados da consulta
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">PESQUISA</p>
                        <h1 class="display-5 mb-4">LISTA DE ONGS</h1>
                        <form action="pesquisa_ongs.php" method="GET">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-3">
                                    <label for="nome">NOME DA ONG</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent "
                                        name="nome_fantasia" placeholder="NOME DA ONG"
                                        value="<?= htmlspecialchars($nome_fantasia) ?>">
                                </div>
                                <div class="col-xl-3">
                                    <label for="cidade">CIDADE</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent " name="cidade"
                                        placeholder="CIDADE" value="<?= htmlspecialchars($cidade) ?>">
                                </div>
                                <div class="col-xl-3">
                                    <label for="estado">ESTADO</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent " name="estado"
                                        placeholder="ESTADO" value="<?= htmlspecialchars($estado) ?>">
                                </div>
                                <div class="col-xl-3">
                                    <label for="cep">CEP</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent " name="cep"
                                        placeholder="CEP" value="<?= htmlspecialchars($cep) ?>">
                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary  w-100 py-3 px-5">PESQUISAR</button>
                                </div>
                            </div>
                        </form>

                        <br>
                        <div class="row">
                            <div class="col-12">
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                <table class="table table-bordered table-hover bg-transparent ">
                                    <thead class="bg-primary ">
                                        <tr>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Nome da ONG</th>
                                            <th scope="col">Endereço</th>
                                            <th scope="col">Cidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td>
                                                <img src="<?= htmlspecialchars($row['foto_perfil']) ?>"
                                                    alt="Foto de <?= htmlspecialchars($row['nome_fantasia']) ?>"
                                                    class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                            </td>
                                            <td><?= htmlspecialchars($row['nome_fantasia']) ?></td>
                                            <td><?= htmlspecialchars($row['endereco']) ?></td>
                                            <td><?= htmlspecialchars($row['cidade']) ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <?php else: ?>
                                <p>Nenhuma ONG encontrada.</p>
                                <?php endif; ?>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./rodape.php');
?>