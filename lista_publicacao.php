<?php
include('./cabecalho.php');
include('./lista_publicacao_model.php');
?>


<div class="container-fluid feature py-5">

    <div class="container py-5">
        <div class="container py-3">
            <form method="GET" action="lista_publicacao.php">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="estado">ESTADO</label>
                        <select class="form-control" name="estado" id="estado" data-id="estado">
                            <option value="">Selecione o Estado</option>
                            <?php foreach ($estados as $estado): ?>
                                <option value="<?php echo $estado['Id']; ?>">
                                    <?php echo $estado['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="cidade">CIDADE</label>
                        <select id="cidade" class="form-control" name="cidade">
                            <option value="">Selecione a Cidade</option>
                        </select>
                    </div>
                    <!-- Filtro de data da publicação -->
                    <div class="col-md-3">
                        <label for="data_publicacao" class="form-label">Data de Publicação</label>
                        <input type="date" name="data_publicacao" id="data_publicacao" class="form-control">
                    </div>
                    <!-- Filtro de ONG -->
                    <div class="col-md-3">
                        <label for="id_ong" class="form-label">ONG</label>
                        <select name="id_ong" id="id_ong" class="form-control">
                            <option value="">Selecione uma ONG</option>
                            <?php
                            $ongs = getOngs(); // Função para buscar todas as ONGs
                            foreach ($ongs as $ong) {
                                echo "<option value='{$ong['id_ong']}'>{$ong['nome_fantasia']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>
        
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">PUBLICAÇÕES</h4>
            </div>
        </div>
        <?php foreach ($list_publicacoes as $key => $publicacoes) {
            // Criar o objeto DateTime a partir do formato 'Y-m-d H:i:s'
            $dataPublicacao = DateTime::createFromFormat('Y-m-d H:i:s', $publicacoes['dtpublicacao']);
            // Formatar a data para 'd-m-Y' ou outro formato desejado
            $dataFormatada = $dataPublicacao ? $dataPublicacao->format('d-m-Y') : '';

        ?>

            <div class="d-flex justify-content-center align-items-center text-center mb-4">

                <div class="card" style="width: 30rem;">
                    <a href="./cadastro_publicacao.php?id_publicacao=<?php echo $publicacoes['id_publicacoes'] ?>">
                        <div class="card-header d-flex justify-content-between">
                            <span class="text-left"><?php echo $publicacoes['nome_fantasia'] ?></span>
                            <span class="text-right"><?php echo $dataFormatada ?></span>
                        </div>
                        <img class="card-img-top" src="./<?php echo $publicacoes['arquivo'] ?>" alt="Card image cap" style="height: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $publicacoes['titulo'] ?></h5>
                            <p class="card-text"><?php echo $publicacoes['descricao'] ?></p>
                        </div>
                    </a>
                    <?php
                    $mensagemCompartilhamento = rawurlencode(
                        "Confira a publicação de " . $publicacoes['nome_fantasia'] . " 🌟 " . "\n\n" .
                            $publicacoes['titulo'] . "!\n\n" .  // Quebra de linha dupla
                            $publicacoes['descricao'] . "\n\n" .  // Outra quebra de linha entre descrição e o link
                            "Acesse a publicação: http://localhost/tcc/Naong/cadastro_publicacao.php?id_publicacao=" . $publicacoes['id_publicacoes']
                    );
                    ?>

                    <div class="card-footer text-muted" style="cursor: pointer;">
                        <a class="dropdown-item" href="https://api.whatsapp.com/send?text=<?php echo $mensagemCompartilhamento; ?>" target="_blank">
                            <i class="fa fa-whatsapp" aria-hidden="true"></i> Compartilhar no WhatsApp
                        </a>
                    </div>



                </div>

            </div>

            <hr>
        <?php } ?>
    </div>
</div>
<script>
    document.getElementById('estado').addEventListener('change', function() {
        var id_estado = this.value;
        var cidadeSelect = document.getElementById('cidade');

        // Limpa as opções anteriores de cidade
        cidadeSelect.innerHTML = '<option value="">Selecione a Cidade</option>';

        // Verifica se um estado foi selecionado
        if (id_estado !== "") {
            // Ativa o campo de cidade
            cidadeSelect.disabled = false;

            // Faz a requisição AJAX para obter as cidades do estado selecionado
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'buscar_cidades.php?id_estado=' + id_estado, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var cidades = JSON.parse(this.responseText);

                    // Adiciona as cidades ao dropdown
                    cidades.forEach(function(cidade) {
                        var option = document.createElement('option');
                        option.value = cidade.id; // ID da cidade
                        option.textContent = cidade.nome; // Nome da cidade
                        cidadeSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        } else {
            // Desativa o campo de cidade se nenhum estado foi selecionado
            cidadeSelect.disabled = true;
        }
    });
</script>

<?php include('./rodape.php') ?>