<?php

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
$get_departamento = isset($_GET['id_departamento']) ? $_GET['id_departamento'] : '';

function getDepartamentos() {
    global $conn; // Certifique-se de que a variável de conexão está disponível

    // Teste se a conexão está funcionando
    if (!$conn) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    // Verificar se a consulta SQL está funcionando corretamente
    $query = "SELECT id_departamento, nome_departamento FROM departamentos";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro ao executar a query: " . mysqli_error($conn));
    }

    $departamentos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $departamentos[] = $row;
    }

    return $departamentos;
}

//$conn->close();

?>
