<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'banco.php';

header('Content-Type: application/json');

// Verifique se o parâmetro estado_id foi passado corretamente
if (isset($_GET['estado_id'])) {
    $estadoId = $_GET['estado_id'];
} else {
    echo json_encode(["erro" => "Parâmetro estado_id ausente"]);
    exit;
}

$cidades = [];

if (is_numeric($estadoId)) {
    $estadoId = intval($estadoId);

    $query = "SELECT Id, nome FROM Cidades WHERE id_estado = $estadoId ORDER BY nome";
    $result = $conn->query($query);

    if ($result) {
        while ($cidade = $result->fetch_assoc()) {
            $cidades[] = $cidade;
        }
    } else {
        error_log("Erro na consulta SQL: " . $conn->error);
        echo json_encode(["erro" => "Erro ao consultar as cidades"]);
        exit;
    }
} else {
    error_log("estado_id não é um valor numérico válido.");
    echo json_encode(["erro" => "Parâmetro estado_id inválido"]);
    exit;
}

// Retorna o JSON ou um erro padrão
if (empty($cidades)) {
    echo json_encode(["erro" => "Nenhuma cidade encontrada"]);
} else {
    echo json_encode($cidades);
}
?>
