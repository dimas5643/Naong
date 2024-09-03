<?php
include('./cabecalho.php');
include './banco.php';
include('./perfil_ong_model.php');

?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">DADOS DO PERFIL</p>
                        <h1 class="display-5 mb-4">PERFIL</h1>
                        <?php if (!empty($row['foto_perfil'])) : ?>
                            <img src="<?php echo $row['foto_perfil']; ?>" alt="Foto de Perfil" style="width: 150px; height: 150px; border-radius: 50%;">
                        <?php endif; ?>
                        <form action="atualizar_<?php echo $user_role; ?>.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id_' . $user_role]; ?>">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <label for="">NOME</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome" placeholder="NOME" value="<?php echo isset($row['nome_fantasia']) ? $row['nome_fantasia'] : $row['nome']; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">DOCUMENTO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="documento" placeholder="DOCUMENTO" value="<?php echo isset($row['cnpj']) ? $row['cnpj'] : $row['documento']; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CEP</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="cep" placeholder="CEP" value="<?php echo isset($row['cep']) ? $row['cep'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">ESTADO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="estado" placeholder="ESTADO" value="<?php echo isset($row['estado']) ? $row['estado'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CIDADE</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="cidade" placeholder="CIDADE" value="<?php echo isset($row['cidade']) ? $row['cidade'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">ENDEREÇO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="endereco" placeholder="ENDEREÇO" value="<?php echo isset($row['endereco']) ? $row['endereco'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">CONTATO</label>
                                    <input type="phone" class="form-control py-3 border-primary bg-transparent" name="contato" placeholder="CONTATO" value="<?php echo isset($row['telefone']) ? $row['telefone'] : $row['contato']; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">EMAIL</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="email" placeholder="EMAIL" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">SENHA</label>
                                    <input type="password" class="form-control py-3 border-primary bg-transparent" name="senha" placeholder="SENHA">
                                </div>

                                <div class="col-xl-6">
                                    <label for="">ÁREA DE ATUAÇÃO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent" name="area_atuacao" placeholder="ÁREA DE ATUAÇÃO" value="<?php echo isset($row['area_atuacao']) ? $row['area_atuacao'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">DEPARTAMENTO DA NECESSIDADE</label>
                                    <select class="form-control py-3 border-primary bg-transparent" name="departamento">
                                        <option value=""></option>
                                        <?php foreach ($list_departamentos as $departamentos) { ?>
                                            <option value="<?php echo $departamentos['id_departamento']; ?>" <?php if (isset($row['id_departamento'])) {
                                                                                                                    echo $row['id_departamento'] == $departamentos['id_departamento'] ? 'selected' : '';
                                                                                                                } ?>><?php echo $departamentos['nome_departamento']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <label for="">FOTO DE PERFIL</label>
                                    <input type="file" class="form-control py-3 border-primary bg-transparent" name="foto_perfil">
                                </div>
                                <div class="col-xl-12">
                                    <label for="" class="form-label">DESCRIÇÃO DA NECESSIDADE</label>
                                    <textarea class="form-control py-3 border-primary bg-transparent" name="descricao" rows="5" placeholder="DESCRIÇÃO DA NECESSIDADE"><?php echo isset($row['descricao']) ? $row['descricao'] : ''; ?></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary text-white w-100 py-3 px-5">ATUALIZAR</button>
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

                <div class="card text-center">
                    <a href="./cadastro_publicacao.php?id_publicacao=<?php echo $publicacoes['id_publicacoes'] ?>">
                        <img src="./<?php echo $publicacoes['arquivo'] ?>" class="card-img-top">
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

            <?php } ?>

        </div>
    </div>
</div>

<?php
include('./rodape.php');
?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-N9uCpQNAjSVptM-LjXOCmfS19UZiPhs&callback=initMap" async defer></script>
<script>
    function initMap() {
        var geocoder = new google.maps.Geocoder();
        var address = "<?php echo $row['endereco'] . ', ' . $row['cidade'] . ', ' . $row['estado'] . ', ' . $row['pais']; ?>";

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
</script>