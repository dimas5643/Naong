<?php
include('./cabecalho.php');
include('./cadastro_publicacao_model.php');
include './banco.php';

$hidden = '';
$disabled = '';
if (!isset($_SESSION['user_id']) || ($row && $_SESSION['user_id'] != $row['id_ong'])) {
    $hidden = 'hidden';
    $disabled = 'disabled';
}
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
                            $mensagem = 'Você não tem permissão para alterar essa publicação!';
                            break;
                        case '4':
                            $mensagem = 'Houve um erro ao enviar o arquivo. Tente novamente.';
                            break;
                        case '5':
                            $mensagem = 'Tipo de arquivo não permitido! Apenas JPG, JPEG e PNG são aceitos.';
                            break;
                        case '6':
                            $mensagem = 'O arquivo é muito grande! O tamanho máximo permitido é 25MB.';
                            break;
                        case '7':
                            $mensagem = 'O arquivo enviado não é uma imagem válida.';
                            break;
                        case '8':
                            $mensagem = 'Erro ao salvar!';
                            break;
                        case '9':
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
                        <p class="fs-4 text-uppercase text-primary">DADOS DA PUBLICAÇÃO</p>
                        <h1 class="display-5 mb-4">PUBLICAÇÕES</h1>
                        <form action="cadastro_publicacao_model.php" method="POST" enctype="multipart/form-data">
                            <?php if (isset($row['id_publicacoes'])) { ?>
                                <input type="hidden" name="id_publicacoes" value="<?php echo $row['id_publicacoes'] ?>">
                            <?php } ?>

                            <div class="row gy-3 gx-4">
                                <div class="col-xl-12">
                                    <label for="">TITULO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent " name="titulo" placeholder="TITULO" value="<?php echo isset($row['titulo']) ? $row['titulo'] : ''; ?>" <?php echo $disabled ?>>
                                </div>

                                <div class="col-xl-12">
                                    <label for="" class="form-label">DESCRIÇÃO</label>
                                    <textarea class="form-control py-3 border-primary bg-transparent" name="descricao" rows="5" placeholder="DESCRIÇÃO" <?php echo $disabled ?>><?php echo isset($row['descricao']) ? $row['descricao'] : ''; ?></textarea>
                                </div>


                                <div class="col-xl-12">
                                    <label for="">FOTO</label>
                                    <?php if (isset($row)) { ?>
                                        <img src="./<?php echo $row['arquivo'] ?>" class="img-fluid" alt="Responsive image">
                                    <?php } ?>
                                    <?php if ($hidden != 'hidden') {  ?>
                                        <input type="file" class="form-control py-3 border-primary bg-transparent" name="foto">
                                    <?php } ?>
                                </div>

                                <?php if ($hidden != 'hidden') {  ?>
                                    <div class="col-xl-11">
                                        <label for="">PONTOS DE COLETA</label>
                                        <select class="form-control py-3 border-primary bg-transparent" name="coleta">
                                            <?php foreach ($list_pontos_coleta as $pontos_coleta) { ?>
                                                <?php
                                                // Verificar se o ponto de coleta já foi selecionado
                                                $selected = false;
                                                if (isset($list_publicacao_pontos_coleta)) {
                                                    foreach ($list_publicacao_pontos_coleta as $ponto) {
                                                        if ($ponto['id'] == $pontos_coleta['id']) {
                                                            $selected = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?php if (!$selected) { ?>
                                                    <option value="<?php echo $pontos_coleta['id']; ?>"><?php echo $pontos_coleta['nome']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-xl-1">
                                        <label for="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <button type="button" class="btn btn-success  py-3 px-4" id="buttonAddPontosColeta">+</button>
                                    </div>

                                <?php } ?>
                            </div>

                            <div class="col-xl-12" style="margin-top: 30px;">
                                <label for="">PONTOS DE COLETA ADICIONADOS</label>
                                <table class="table table-bordered" id="pontosColetaTable">
                                    <thead>
                                        <tr>
                                            <th>Ponto de Coleta</th>
                                            <?php if ($hidden != 'hidden') {  ?>
                                                <th class="text-end">Ação</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($list_publicacao_pontos_coleta) && count($list_publicacao_pontos_coleta) > 0) { ?>
                                            <?php foreach ($list_publicacao_pontos_coleta as $ponto) { ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="pontos_coleta[]" value="<?php echo $ponto['id']; ?>">
                                                        <?php echo $ponto['nome']; ?>
                                                    </td>
                                                    <?php if ($hidden != 'hidden') {  ?>
                                                        <td class="text-end">
                                                            <button type="button" class="btn btn-danger btnRemovePontoColeta">Remover</button>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>

                            <?php if ($hidden != 'hidden') { ?>
                                <button type="submit" class="btn btn-primary  w-100 py-3 px-5">PUBLICAR</button>
                                <?php if (isset($row)) { ?>
                                    <button type="submit" name="acao" value="excluir" class="btn btn-danger  w-100 py-3 px-5" style="margin-top: 15px;">EXCLUIR</button>
                                <?php } ?>
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
    document.getElementById('buttonAddPontosColeta').addEventListener('click', function() {
        var selectColeta = document.querySelector('select[name="coleta"]');
        var selectedOption = selectColeta.options[selectColeta.selectedIndex];
        var tableBody = document.querySelector('#pontosColetaTable tbody');

        if (selectedOption.value) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>
                <input type="hidden" name="pontos_coleta[]" value="${selectedOption.value}">
                ${selectedOption.text}
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-danger btnRemovePontoColeta">Remover</button>
            </td>
        `;
            tableBody.appendChild(newRow);

            // Remover a opção do select após adicionar
            selectColeta.remove(selectColeta.selectedIndex);
        }
    });

    // Remover ponto de coleta da tabela
    document.getElementById('pontosColetaTable').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btnRemovePontoColeta')) {
            var row = e.target.closest('tr');
            var pontoColetaValue = row.querySelector('input[name="pontos_coleta[]"]').value;
            var pontoColetaText = row.cells[0].textContent.trim();

            // Adicionar a opção de volta ao select
            var selectColeta = document.querySelector('select[name="coleta"]');
            var option = document.createElement('option');
            option.value = pontoColetaValue;
            option.textContent = pontoColetaText;
            selectColeta.appendChild(option);

            // Remover a linha da tabela
            row.remove();
        }
    });
</script>