<?php
include 'banco.php'; // Inclui o arquivo de conexão ao banco

if (isset($_GET['id_estado'])) {
    $id_estado = $_GET['id_estado'];

    // Consulta para buscar cidades pelo ID do estado
    $sql = "SELECT id, nome FROM Cidades WHERE id_estado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_estado);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $cidades = [];
    while ($row = $resultado->fetch_assoc()) {
        $cidades[] = $row;
    }

    // Retorna as cidades em formato JSON
    echo json_encode($cidades);
}
?>
