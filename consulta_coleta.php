<?php
include('./cabecalho.php');
include('consulta_coleta_model.php'); // Inclua o model para obter os dados
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="display-5">PONTOS DE COLETA</h1>
                            <a href="coleta.php" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Cadastrar Ponto de Coleta
                            </a>
                        </div>

                        <!-- Tabela para exibir pontos de coleta -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Rua</th>
                                    <th>Cidade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pontos_coleta)) : ?>
                                    <?php foreach ($pontos_coleta as $ponto) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($ponto['nome']); ?></td>
                                            <td><?php echo htmlspecialchars($ponto['rua']); ?></td>
                                            <td><?php echo htmlspecialchars($ponto['cidade']); ?></td>
                                            <td>
                                                <a href="editar.php?id=<?php echo $ponto['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                                <a href="excluir.php?id=<?php echo $ponto['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr><td colspan="4">Nenhum ponto de coleta encontrado.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./rodape.php');
?>
