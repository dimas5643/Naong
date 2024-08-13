<?php
session_start();

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "naong";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obtenha o ID do usuário da sessão
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// Consulta para obter todos os pontos de coleta da ONG logada
if ($user_role == 'ong') {
    $sql = "SELECT * FROM pontos_coleta WHERE ong = $user_id";
} else {
    $sql = "SELECT * FROM pontos_coleta";
}

$result = $conn->query($sql);

if ($result === false) {
    echo "Erro na consulta: " . $conn->error;
    exit;
}

$pontos_coleta = [];
while ($row = $result->fetch_assoc()) {
    $pontos_coleta[] = $row;
}

$conn->close();
?>
