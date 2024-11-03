<?php
include 'banco.php'; // Inclui o arquivo de conexão ao banco

// Consulta para obter os estados
$sql = "SELECT Id, nome, UF FROM Estados ORDER BY nome ASC";
$resultado = $conn->query($sql);

// Armazena os estados em um array
$estados = [];
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $estados[] = $row;
    }
}
?>

<?php include('./cabecalho.php') ?>
<!-- Book Appointment Start -->
<div class="container-fluid appointment py-12">
    <div class="container py-12">
        <div class="row g-12 align-items-center">
            <div class="col-sm-12" style="padding-top: 150px; padding-bottom: 50px;">
                <?php
                // Mensagens de erro
                if (isset($_GET['erro'])) {
                    $mensagem = '';
                    switch ($_GET['erro']) {
                        case '1':
                            $mensagem = 'Preencha todos os dados!';
                            break;
                        case '2':
                            $mensagem = 'Erro ao salvar!';
                            break;
                        case '3':
                            $mensagem = 'Erro ao salvar o endereço, tente novamente!';
                            break;
                        case '4':
                            $mensagem = 'Email já em uso, tente novamente!';
                            break;
                        case '5':
                            $mensagem = 'CPF/CNPJ já em uso, tente novamente!';
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
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-doador-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-doador" type="button" role="tab" aria-controls="pills-doador"
                            aria-selected="true">Doador</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-ong-tab" data-bs-toggle="pill" data-bs-target="#pills-ong"
                            type="button" role="tab" aria-controls="pills-ong" aria-selected="false">ONG</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-doador" role="tabpanel"
                        aria-labelledby="pills-doador-tab">
                        <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                            <div class="appointment-form rounded p-5">
                                <p class="fs-4 text-uppercase text-primary">Preencha o formulário</p>
                                <h1 class="display-5 mb-4">Cadastro de Doador</h1>
                                <form action="doador_model.php" method="POST">
                                    <div class="row gy-3 gx-4">
                                        <div class="col-xl-6">
                                            <label for="">NOME</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="nome" placeholder="NOME">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="documento">DOCUMENTO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="documento" id="documento" placeholder="CPF/CNPJ" maxlength="18">
                                        </div>

                                        <script>
                                        document.getElementById('documento').addEventListener('input', function(e) {
                                            let value = e.target.value.replace(/\D/g,
                                                ''); // Remove caracteres não numéricos

                                            // Verifica o tamanho do valor e aplica a máscara adequada
                                            if (value.length <= 11) {
                                                // Máscara para CPF: 000.000.000-00
                                                e.target.value = value.replace(/(\d{3})(\d)/, '$1.$2')
                                                    .replace(/(\d{3})(\d)/, '$1.$2')
                                                    .replace(/(\d{3})(\d{2})$/, '$1-$2');
                                            } else {
                                                // Máscara para CNPJ: 00.000.000/0000-00
                                                e.target.value = value.replace(/^(\d{2})(\d)/,
                                                        '$1.$2') // Adiciona o primeiro ponto
                                                    .replace(/^(\d{2}\.\d{3})(\d)/,
                                                        '$1.$2') // Adiciona o segundo ponto
                                                    .replace(/^(\d{2}\.\d{3}\.\d{3})(\d)/,
                                                        '$1/$2') // Adiciona a barra
                                                    .replace(/^(\d{2}\.\d{3}\.\d{3}\/\d{4})(\d)/,
                                                        '$1-$2'); // Adiciona o hífen
                                            }
                                        });
                                        </script>


                                        <div class="col-xl-6">
                                            <label for="">ESTADO</label>
                                            <select class="form-control py-3 border-primary bg-transparent"
                                                name="estado" id="estado" data-id="estado">
                                                <option value="">Selecione o Estado</option>
                                                <?php foreach ($estados as $estado): ?>
                                                <option value="<?php echo $estado['Id']; ?>">
                                                    <?php echo $estado['nome']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CIDADE</label>
                                            <select id="cidade" class="form-control py-3 border-primary bg-transparent"
                                                name="cidade" disabled>
                                                <option value="">Selecione a Cidade</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="cep">CEP</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="cep" id="cep" placeholder="CEP">
                                        </div>

                                        <script>
                                        document.getElementById('cep').addEventListener('input', function(e) {
                                            let value = e.target.value.replace(/\D/g,
                                                ''); // Remove caracteres não numéricos
                                            if (value.length > 5) {
                                                value = value.slice(0, 5) + '-' + value.slice(5,
                                                    8); // Adiciona o hífen
                                            }
                                            e.target.value = value; // Atualiza o campo com a máscara
                                        });
                                        </script>

                                        <div class="col-xl-6">
                                            <label for="">ENDEREÇO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent "
                                                name="endereco" placeholder="ENDEREÇO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CONTATO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="celular" placeholder="CONTATO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">EMAIL</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent "
                                                name="email" placeholder="EMAIL">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">SENHA</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="senha" placeholder="SENHA">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">DATA DE NASCIMENTO</label>
                                            <input type="date" class="form-control py-3 border-primary bg-transparent"
                                                name="data_nascimento">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit"
                                                class="btn btn-primary  w-100 py-3 px-5">CADASTRAR</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-ong" role="tabpanel" aria-labelledby="pills-ong-tab">
                        <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                            <div class="appointment-form rounded p-5">
                                <p class="fs-4 text-uppercase text-primary">Preencha o formulário</p>
                                <h1 class="display-5 mb-4">Cadastro de ONG</h1>
                                <form action="ong_model.php" method="POST">
                                    <div class="row gy-3 gx-4">
                                        <div class="col-xl-6">
                                            <label for="">NOME</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent "
                                                name="nome" placeholder="NOME">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="documento">DOCUMENTO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="documento" id="documento" placeholder="CPF/CNPJ" maxlength="18">
                                        </div>

                                        <script>
                                        document.getElementById('documento').addEventListener('input', function(e) {
                                            // Máscara para CNPJ: 00.000.000/0000-00
                                            e.target.value = value.replace(/^(\d{2})(\d)/,
                                                    '$1.$2') // Adiciona o primeiro ponto
                                                .replace(/^(\d{2}\.\d{3})(\d)/,
                                                    '$1.$2') // Adiciona o segundo ponto
                                                .replace(/^(\d{2}\.\d{3}\.\d{3})(\d)/,
                                                    '$1/$2') // Adiciona a barra
                                                .replace(/^(\d{2}\.\d{3}\.\d{3}\/\d{4})(\d)/,
                                                    '$1-$2'
                                                    ); // Adiciona o hífen                                            
                                        });
                                        </script>
                                        <div class="col-xl-6">
                                            <label for="">ESTADO</label>
                                            <select class="form-control py-3 border-primary bg-transparent"
                                                name="estado" id="estado-ong" data-id="estado-ong">
                                                <option value="">Selecione o Estado</option>
                                                <?php foreach ($estados as $estado): ?>
                                                <option value="<?php echo $estado['Id']; ?>">
                                                    <?php echo $estado['nome']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CIDADE</label>
                                            <select id="cidade-ong"
                                                class="form-control py-3 border-primary bg-transparent" name="cidade"
                                                disabled>
                                                <option value="">Selecione a Cidade</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-6">
                                            <label for="cep">CEP</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="cep" id="cep2" placeholder="CEP">
                                        </div>

                                        <script>
                                        document.getElementById('cep2').addEventListener('input', function(e) {
                                            let value = e.target.value.replace(/\D/g,
                                                ''); // Remove caracteres não numéricos
                                            if (value.length > 5) {
                                                value = value.slice(0, 5) + '-' + value.slice(5,
                                                    8); // Adiciona o hífen
                                            }
                                            e.target.value = value; // Atualiza o campo com a máscara
                                        });
                                        </script>
                                        
                                        <div class="col-xl-6">
                                            <label for="">ENDEREÇO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent "
                                                name="endereco" placeholder="ENDEREÇO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">CONTATO</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent"
                                                name="contato" placeholder="CONTATO">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">EMAIL</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent "
                                                name="email" placeholder="EMAIL">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="">SENHA</label>
                                            <input type="text" class="form-control py-3 border-primary bg-transparent "
                                                name="senha" placeholder="SENHA">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit"
                                                class="btn btn-primary w-100 py-3 px-5">CADASTRAR</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Book Appointment End -->

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
document.getElementById('estado-ong').addEventListener('change', function() {
    var id_estado = this.value;
    var cidadeSelect = document.getElementById('cidade-ong');

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