<?php
include('./cabecalho.php');
include('./pesquisa_ongs_model.php');

// Configuração da conexão com o banco de dados
try {
    $db = new PDO('mysql:host=localhost;dbname=naong', 'usuario', 'senha');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Instanciando o model
$model = new PesquisaOngsModel($db);

// Obtendo os parâmetros da pesquisa
$nome = isset($_GET['nome_fantasia']) ? $_GET['nome_fantasia'] : null;
$endereco = isset($_GET['endereco']) ? $_GET['endereco'] : null;
$estado = isset($_GET['estado']) ? $_GET['estado'] : null;

// Realizando a pesquisa
$ongs = $model->pesquisarOngs($nome_fantasia, $endereco, $estado);

// Incluindo o HTML da pesquisa
include('./pesquisa_ongs.php');
include('./rodape.php');
?>
