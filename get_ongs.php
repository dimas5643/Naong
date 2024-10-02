<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "naong";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para buscar as ONGs
$sql = "SELECT nome_fantasia, endereco, latitude, longitude, id_ong, id_departamento FROM ongs WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

$ongs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ongs[] = $row;
    }
}

$conn->close();

// Retorna os dados em formato JSON
echo json_encode($ongs);
