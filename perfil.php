<?php
include('./cabecalho.php');
include('departamento_model.php');
include './banco.php';

$id = 0; //$_GET['id'];

$sql = "SELECT * FROM ongs WHERE id_ong = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Nenhum registro encontrado.";
    exit;
}

?>

<div class="container-fluid appointment py-12" style="padding-top: 100px; padding-bottom: 50px;">
    <div class="container py-12" style="margin-top: 50px; padding-bottom: 50px;">
        <div class="row g-12 align-items-center">
            <div class="col-lg-12">
                <div class="col-lg-12 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="appointment-form rounded p-5">
                        <p class="fs-4 text-uppercase text-primary">DADOS DO PERFIL</p>
                        <h1 class="display-5 mb-4">PERFIL</h1>
                        <?php if (!empty($row['foto_perfil'])): ?>
                            <img src="<?php echo $row['foto_perfil']; ?>" alt="Foto de Perfil" style="width: 150px; height: 150px; border-radius: 50%;">
                        <?php endif; ?>
                        <form action="atualizar_ong.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id_ong']; ?>">
                            <div class="row gy-3 gx-4">
                                <div class="col-xl-6">
                                    <label for="">NOME</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="nome" placeholder="NOME" value="<?php echo isset($row['nome_fantasia']) ? $row['nome_fantasia'] : ''; ?>">
                                </div>
                                <div class="col-xl-6">
                                    <label for="">DOCUMENTO</label>
                                    <input type="text" class="form-control py-3 border-primary bg-transparent text-white" name="documento" placeholder="DOCUMENTO" value="<?php echo isset($row['cnpj']) ? $row['cnpj'] : ''; ?>">
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
                                    <input type="phone" class="form-control py-3 border-primary bg-transparent" name="contato" placeholder="CONTATO" value="<?php echo isset($row['telefone']) ? $row['telefone'] : ''; ?>">
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
                                    <label for="">FOTO DE PERFIL</label>
                                    <input type="file" class="form-control py-3 border-primary bg-transparent" name="foto_perfil">
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
    </div>
</div>
<?php
include('./rodape.php');
?>
