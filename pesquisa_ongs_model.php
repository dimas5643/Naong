<?php
$servername = "localhost"; // ou o nome do servidor
$username = "root";
$password = "";
$database = "naong";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Pegue os parâmetros de pesquisa
$nome_fantasia = $_GET['nome_fantasia'] ?? '';
$cidade = $_GET['cidade'] ?? '';
$estado = $_GET['estado'] ?? '';
$cep = $_GET['cep'] ?? '';

// Monte a consulta com filtros
$query = "SELECT * FROM ongs WHERE 1=1";
if (!empty($nome_fantasia)) {
    $query .= " AND nome_fantasia LIKE '%$nome_fantasia%'";
}
if (!empty($cidade)) {
    $query .= " AND cidade LIKE '%$cidade%'";
}
if (!empty($estado)) {
    $query .= " AND estado LIKE '%$estado%'";
}
if (!empty($cep)) {
    $query .= " AND cep LIKE '%$cep%'";
}

// Execute a consulta
$result = mysqli_query($conn, $query);

// Verifica se houve erro na consulta
if (!$result) {
    die('Erro na consulta: ' . mysqli_error($conn));
}

mysqli_close($conn); // Feche a conexão com o banco de dados
?>
