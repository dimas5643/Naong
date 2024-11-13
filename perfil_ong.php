<?php
include('./cabecalho.php');
include './banco.php';
include('./perfil_ong_model.php');

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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Texto "DADOS DO PERFIL" -->
                            <p class="fs-4 text-uppercase text-primary mb-0">DADOS DO PERFIL</p>

                            <!-- Botão com os três risquinhos (dropdown) no canto direito -->
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <?php
                                        $mensagemCompartilhamento = urlencode(
                                            "Conheça o incrível trabalho da ONG " . $row['nome_fantasia'] . "! 🌟 
A organização está fazendo a diferença com suas iniciativas e projetos impactantes. 
Acesse o perfil completo e descubra como eles estão transformando vidas: http://localhost/tcc/Naong/perfil_ong.php?id_ong=" . $row['id_ong']
                                        );
                                        ?>
                                        <a class="dropdown-item"
                                            href="https://api.whatsapp.com/send?text=<?php echo $mensagemCompartilhamento; ?>"
                                            target="_blank">
                                            <i class="fa fa-whatsapp" aria-hidden="true"></i> Compartilhar no WhatsApp
                                        </a>

                                    </li>
                                    <!-- Outros itens -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-around align-items-center"
                            style="font-size: 14pt;">

                            <div class="row">
                                <div class="col-md-5">
                                    <img src="<?php echo $row['foto_perfil']; ?>" alt="Foto de Perfil"
                                        class="img-fluid rounded-circle" style=" border-radius: 50%;">
                                </div>

                                <div class="col-md-4">
                                    <h2 class="mt-3">Informações Pessoais</h2>
                                    <p><strong>Nome:</strong> <?php echo $row['nome_fantasia']; ?></p>
                                    <p><strong>Email:</strong> <a
                                            href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
                                    </p>
                                    <p><strong>Area:</strong> <?php echo $row['area_atuacao']; ?></p>
                                    <p><strong>Necessidade:</strong> <i class="<?php echo $row['icon']; ?>"></i>
                                        <?php echo $row['nome_departamento']; ?></p>


                                </div>
                                <div class="col-md-3">
                                    <h2 class="mt-3">Redes Sociais</h2>
                                    <?php if (isset($row['facebook'])) { ?>
                                        <p>
                                            <i class="fa fa-facebook"></i>
                                            <a href="https://facebook.com/<?php echo $row['facebook']; ?>"
                                                target="_blank"><?php echo $row['facebook']; ?></a>
                                        </p>
                                    <?php } ?>
                                    <?php if (isset($row['instagram'])) { ?>
                                        <p>
                                            <i class="fa fa-instagram"></i>
                                            <a href="https://instagram.com/<?php echo $row['instagram']; ?>"
                                                target="_blank"><?php echo $row['instagram']; ?></a>
                                        </p>
                                    <?php } ?>
                                    <?php if (isset($row['site'])) { ?>
                                        <p>
                                            <i class="fa fa-globe"></i>
                                            <a href="<?php echo (strpos($row['site'], 'http') === 0 ? '' : 'https://') . $row['site']; ?>"
                                                target="_blank"><?php echo $row['site']; ?></a>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <form action="atualizar_<?php echo $user_role; ?>.php" method="POST"
                            enctype="multipart/form-data">
                            <?php if ($mostraCampo) { ?>
                                <input type="hidden" name="id" value="<?php echo $row['id_' . $user_role]; ?>">
                            <?php } ?>
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <label for="">NOME</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent"
                                        name="nome" placeholder="NOME"
                                        value="<?php echo isset($row['nome_fantasia']) ? $row['nome_fantasia'] : $row['nome']; ?>"
                                        <?php echo $disabled ?>>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">DOCUMENTO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent"
                                        name="documento" placeholder="DOCUMENTO"
                                        value="<?php echo isset($row['cnpj']) ? $row['cnpj'] : $row['cpf_cnpj']; ?>"
                                        <?php echo $disabled ?>>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CEP</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent"
                                        name="cep" placeholder="CEP"
                                        value="<?php echo isset($row['cep']) ? $row['cep'] : ''; ?>"
                                        <?php echo $disabled ?>>
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
                                    <input type="text" class="form-control py-3 border-primary bg-transparent"
                                        name="endereco" placeholder="ENDEREÇO"
                                        value="<?php echo isset($row['endereco']) ? $row['endereco'] : ''; ?>"
                                        <?php echo $disabled ?>>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CONTATO</label>
                                    <input type="phone" class="form-control py-3 border-primary bg-transparent"
                                        name="contato" placeholder="CONTATO"
                                        value="<?php echo isset($row['telefone']) ? $row['telefone'] : $row['contato']; ?>"
                                        <?php echo $disabled ?>>
                                </div>
                                <?php if ($mostraCampo) { ?>
                                    <div class="col-xl-6">
                                        <label for="">EMAIL</label>
                                        <input type="text" class="form-control py-3 border-primary bg-transparent"
                                            name="email" placeholder="EMAIL"
                                            value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>"
                                            <?php echo $disabled ?>>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="">SENHA</label>
                                        <input type="password" class="form-control py-3 border-primary bg-transparent"
                                            name="senha" placeholder="SENHA">
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="">SITE</label>
                                        <input type="text" class="form-control py-3 border-primary bg-transparent"
                                            name="site" placeholder="SITE"
                                            value="<?php echo isset($row['site']) ? $row['site'] : $row['site']; ?>"
                                            <?php echo $disabled ?>>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="">INSTAGRAM</label>
                                        <input type="text" class="form-control py-3 border-primary bg-transparent"
                                            name="instagram" placeholder="INSTAGRAM"
                                            value="<?php echo isset($row['instagram']) ? $row['instagram'] : $row['instagram']; ?>"
                                            <?php echo $disabled ?>>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="">FACEBOOK</label>
                                        <input type="text" class="form-control py-3 border-primary bg-transparent"
                                            name="facebook" placeholder="FACEBOOK"
                                            value="<?php echo isset($row['facebook']) ? $row['facebook'] : $row['facebook']; ?>"
                                            <?php echo $disabled ?>>
                                    </div>
                                <?php } ?>
                                <div class="col-xl-6">
                                    <label for="">ÁREA DE ATUAÇÃO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent"
                                        name="area_atuacao" placeholder="ÁREA DE ATUAÇÃO"
                                        value="<?php echo isset($row['area_atuacao']) ? $row['area_atuacao'] : ''; ?>"
                                        <?php echo $disabled ?>>
                                </div>


                                <div class="col-xl-6">
                                    <label for="">DEPARTAMENTO DA NECESSIDADE</label>
                                    <select class="form-control py-3 border-primary bg-transparent" name="departamento"
                                        <?php echo $disabled ?>>
                                        <option value=""></option>
                                        <?php foreach ($list_departamentos as $departamentos) { ?>
                                            <option value="<?php echo $departamentos['id_departamento']; ?>" <?php if (isset($row['id_departamento'])) {
                                                                                                                    echo $row['id_departamento'] == $departamentos['id_departamento'] ? 'selected' : '';
                                                                                                                } ?>>
                                                <?php echo $departamentos['nome_departamento']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if ($mostraCampo) { ?>
                                    <div class="col-xl-6">
                                        <label for="">FOTO DE PERFIL</label>
                                        <input type="file" class="form-control py-3 border-primary bg-transparent"
                                            name="foto_perfil">
                                    </div>
                                <?php } ?>
                                <div class="col-xl-12">
                                    <label for="" class="form-label">DESCRIÇÃO DA NECESSIDADE</label>
                                    <textarea class="form-control py-3 border-primary bg-transparent" name="descricao"
                                        rows="5" placeholder="DESCRIÇÃO DA NECESSIDADE"
                                        <?php echo $disabled ?>><?php echo isset($row['descricao']) ? $row['descricao'] : ''; ?></textarea>
                                </div>
                                <div class="col-12">
                                    <?php if ($mostraCampo) { ?>
                                        <button type="submit" class="btn btn-primary w-100 py-3 px-5">ATUALIZAR</button>
                                    <?php } ?>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s" style="margin-top: 50px;">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">MAPA</h4>
            </div>
        </div>

        <div id="map" style="height: 400px; width: 100%; margin-top: 20px;"></div>

        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s" style="margin-top: 50px;">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">ULTIMAS PUBLICAÇÕES</h4>
            </div>
        </div>
        <div class="card-group">
            <?php foreach ($list_publicacoes as $key => $publicacoes) {
                // Criar o objeto DateTime a partir do formato 'Y-m-d H:i:s'
                $dataPublicacao = DateTime::createFromFormat('Y-m-d H:i:s', $publicacoes['dtpublicacao']);
                // Formatar a data para 'd-m-Y' ou outro formato desejado
                $dataFormatada = $dataPublicacao ? $dataPublicacao->format('d-m-Y') : '';
            ?>
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card text-center">
                        <a href="./cadastro_publicacao.php?id_publicacao=<?php echo $publicacoes['id_publicacoes'] ?>">
                            <img src="./<?php echo $publicacoes['arquivo'] ?>"  class="card-img-top img-fluid" style="height: 350px;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $publicacoes['titulo'] ?></h5>
                                <p class="card-text"><?php echo $publicacoes['descricao'] ?></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary d-flex justify-content-between">
                                    <span class="text-left"><?php echo $row['nome_fantasia'] ?></span>
                                    <span class="text-right"><?php echo $dataFormatada ?></span></small>
                            </div>
                        </a>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
</div>

<?php
include('./rodape.php');
?>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-N9uCpQNAjSVptM-LjXOCmfS19UZiPhs&callback=initMap" async
    defer></script> -->
<script>
    $(document).ready(function() {
        initMap();
    });

    function initMap() {
        var geocoder = new google.maps.Geocoder();
        var address =
            "<?php echo $row['endereco'] . ', ' . $nome_cidade . ', ' . $nome_estado . ', ' . 'Brasil'; ?>";

        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === 'OK') {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: results[0].geometry.location
                });
                var marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                });
            } else {
                alert('Geocoding falhou: ' + status);
            }
        });
    }

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