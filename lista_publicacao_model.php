<?php

include 'banco.php';

$estado = isset($_GET['estado']) ? $_GET['estado'] : null;
$cidade = isset($_GET['cidade']) ? $_GET['cidade'] : null;
$data_publicacao = isset($_GET['data_publicacao']) ? $_GET['data_publicacao'] : null;
$id_ong = isset($_GET['id_ong']) ? $_GET['id_ong'] : null;

$sql_list_publicacoes = "SELECT p.*, o.nome_fantasia FROM publicacoes p 
                         INNER JOIN ongs o ON o.id_ong = p.id_ong 
                         WHERE 1=1";

$types = '';
$params = [];

// Filtro de estado
if (!empty($estado)) {
    $sql_list_publicacoes .= " AND o.estado = ?";
    $types .= 'i';
    $params[] = $estado;
}

// Filtro de cidade
if (!empty($cidade)) {
    $sql_list_publicacoes .= " AND o.cidade = ?";
    $types .= 'i';
    $params[] = $cidade;
}

// Filtro de ONG
if (!empty($id_ong)) {
    $sql_list_publicacoes .= " AND p.id_ong = ?";
    $types .= 'i';
    $params[] = $id_ong;
}

// Filtro de data de publicação
if (!empty($data_publicacao)) {
    $sql_list_publicacoes .= " AND DATE(p.dtpublicacao) = ?";
    $types .= 's';
    $params[] = $data_publicacao;
}

// Ordenação e limite de resultados
$sql_list_publicacoes .= " ORDER BY p.dtpublicacao DESC LIMIT 10";

$stmt = $conn->prepare($sql_list_publicacoes);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result_list_publicacoes = $stmt->get_result();
$list_publicacoes = $result_list_publicacoes->fetch_all(MYSQLI_ASSOC);

// Carregar os estados
$sql = "SELECT Id, nome, UF FROM Estados ORDER BY nome ASC";
$resultado = $conn->query($sql);

$estados = [];
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $estados[] = $row;
    }
}

function getOngs()
{
    global $conn;
    $sql = "SELECT id_ong, nome_fantasia FROM ongs ORDER BY nome_fantasia ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
