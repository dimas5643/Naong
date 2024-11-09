<?php
include('./cabecalho.php');
include './banco.php';
include('./perfil_doador_model.php');
?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <?php
                // Mensagens de erro
                if (isset($_GET['erro'])) {
                    $mensagem = '';
                    switch ($_GET['erro']) {
                        case '1':
                            $mensagem = 'Preencha todos os dados!';
                            break;
                        case '2':
                            $mensagem = 'Houve um erro ao enviar o arquivo. Tente novamente.';
                            break;
                        case '3':
                            $mensagem = 'Tipo de arquivo não permitido! Apenas JPG, JPEG e PNG são aceitos.';
                            break;
                        case '4':
                            $mensagem = 'O arquivo é muito grande! O tamanho máximo permitido é 25MB.';
                            break;
                        case '5':
                            $mensagem = 'O arquivo enviado não é uma imagem válida.';
                            break;
                        case '6':
                            $mensagem = 'Erro ao salvar!';
                            break;
                        case '7':
                            $mensagem = 'Nenhum registro encontrado!';
                            break;
                        case '8':
                            $mensagem = 'Usuário inválido!';
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
                        <p class="fs-4 text-uppercase text-primary">DADOS DO PERFIL</p>
                        <h1 class="display-5 mb-4">PERFIL</h1>
                        <?php if (!empty($row['foto_perfil'])) { ?>
                            <img src="<?php echo $row['foto_perfil']; ?>" alt="Foto de Perfil"
                                style="width: 150px; height: 150px; border-radius: 50%;">
                        <?php } ?>
                        <form action="atualizar_<?php echo $user_role; ?>.php" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id_' . $user_role]; ?>">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <label for="">NOME</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent" name="nome"
                                        placeholder="NOME"
                                        value="<?php echo isset($row['nome']) ? $row['nome'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">DOCUMENTO</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent"
                                        name="documento" id="documento" placeholder="DOCUMENTO"
                                        value="<?php echo isset($row['cpf_cnpj']) ? $row['cpf_cnpj'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="cep">CEP</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent" name="cep"
                                        id="cep" placeholder="CEP"
                                        value="<?php echo isset($row['cep']) ? $row['cep'] : ''; ?>" maxlength="10">
                                </div>

                                <div class="col-xl-6">
                                    <label for="estado">ESTADO</label>
                                    <select class="form-control py-3 border-primary bg-transparent" name="estado"
                                        id="estado" <?php echo $disabled; ?>>
                                        <option value="">Selecione o Estado</option>
                                        <?php
                                $query = "SELECT Id, nome FROM Estados ORDER BY nome";
                                $result = $conn->query($query);

                                while ($estado = $result->fetch_assoc()) {
                                    // Verifica se o estado é o selecionado
                                    $selected = isset($row['estado']) && $row['estado'] == $estado['Id'] ? 'selected' : '';
                                    echo '<option value="' . $estado['Id'] . '" ' . $selected . '>' . $estado['nome'] . '</option>';
                                }
                                ?>
                                    </select>
                                </div>

                                <div class="col-xl-6">
                                    <label for="cidade">CIDADE</label>
                                    <select class="form-control py-3 border-primary bg-transparent" name="cidade"
                                        id="cidade" <?php echo $disabled; ?>>
                                        <option value="">Selecione a Cidade</option>
                                        <?php
                                if (isset($row['estado'])) {
                                    $estadoId = $row['estado'];
                                    $query = "SELECT Id, nome FROM Cidades WHERE id_estado = $estadoId ORDER BY nome";
                                    $result = $conn->query($query);

                                    while ($cidade = $result->fetch_assoc()) {
                                        $selected = isset($row['cidade']) && $row['cidade'] == $cidade['Id'] ? 'selected' : '';
                                        echo '<option value="' . $cidade['Id'] . '" ' . $selected . '>' . $cidade['nome'] . '</option>';
                                    }
                                }
                                ?>
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">ENDEREÇO</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent"
                                        name="endereco" placeholder="ENDEREÇO"
                                        value="<?php echo isset($row['endereco']) ? $row['endereco'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CONTATO</label>
                                    <input type="phone" class="form-control py-3 border-primary bg-transparent"
                                        name="contato" placeholder="CONTATO"
                                        value="<?php echo isset($row['telefone']) ? $row['telefone'] : $row['contato']; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">EMAIL</label>
                                    <input type="text"
                                        class="form-control py-3 border-primary bg-transparent" name="email"
                                        placeholder="EMAIL"
                                        value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">SENHA</label>
                                    <input type="password" class="form-control py-3 border-primary bg-transparent"
                                        name="senha" placeholder="SENHA">
                                </div>

                                <div class="col-xl-6">
                                    <label for="">FOTO DE PERFIL</label>
                                    <input type="file" class="form-control py-3 border-primary bg-transparent"
                                        name="foto_perfil">
                                </div>

                                <button type="submit"
                                    class="btn btn-primary w-100 py-3 px-5">ATUALIZAR</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
                                    // Máscara para CEP
                                    document.getElementById('cep').addEventListener('input', function(e) {
                                        let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                                        if (value.length <= 5) {
                                            e.target.value = value; // Apenas os 5 primeiros dígitos
                                        } else {
                                            e.target.value = value.substring(0, 5) + '-' + value.substring(5, 8); // Adiciona o hífen
                                        }
                                    });
                                    document.getElementById('estado').addEventListener('change', function() {
    var estadoId = this.value;
    var cidadeSelect = document.getElementById('cidade');

    // Limpa as opções atuais
    cidadeSelect.innerHTML = '<option value="">Selecione a Cidade</option>';

    if (estadoId) {
        // Realiza a chamada AJAX para buscar_cidades.php
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'buscar_cidades_perfil.php?estado_id=' + estadoId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var cidades = JSON.parse(xhr.responseText);
                cidades.forEach(function(cidade) {
                    var option = document.createElement('option');
                    option.value = cidade.Id;
                    option.text = cidade.nome;
                    cidadeSelect.add(option);
                });
            }
        };
        xhr.send();
    }
});
</script>

<?php
include('./rodape.php');
?>
