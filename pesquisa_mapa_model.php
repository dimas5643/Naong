<?php
header('Content-Type: application/json');

function buscarEnderecos($termo = '') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "naong";

    // Tenta estabelecer a conexão com o banco de dados
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            throw new Exception("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT endereco FROM ongs WHERE cidade LIKE ? OR rua LIKE ? OR estado LIKE ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Falha na preparação da consulta: " . $conn->error);
        }

        $termoBusca = '%' . $termo . '%';
        $stmt->bind_param("sss", $termoBusca, $termoBusca, $termoBusca);
        $stmt->execute();
        $result = $stmt->get_result();

        $enderecos = [];
        while ($row = $result->fetch_assoc()) {
            $enderecos[] = $row['endereco'];
        }

        $stmt->close();
        $conn->close();

        return $enderecos;

    } catch (Exception $e) {
        return ['erro' => $e->getMessage()];
    }
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termo = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
    $enderecos = buscarEnderecos($termo);
    echo json_encode($enderecos);
    exit;
}
?>
