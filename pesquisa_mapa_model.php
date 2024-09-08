<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "naong";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Captura o filtro de departamentos, se fornecido
$departamentos = isset($_GET['departamentos']) ? $_GET['departamentos'] : '';

// Cria a consulta base para buscar ONGs
$sql = "SELECT o.nome_fantasia, o.endereco, o.latitude, o.longitude
        FROM ongs o
        JOIN ongs_departamentos od ON o.id = od.ong_id
        WHERE o.latitude IS NOT NULL AND o.longitude IS NOT NULL";


$ongs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ongs[] = $row;
    }
}

$conn->close();

// Retorna os dados em formato JSON
echo json_encode($ongs);
?>
