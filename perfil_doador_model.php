<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado e obter o ID e o tipo de usuário da sessão
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    $id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Determinar a tabela correta com base no tipo de usuário
    if ($user_role == 'ong') {
        $sql = "SELECT * FROM ongs WHERE id_ong = $id";
    } elseif ($user_role == 'doador') {
        $sql = "SELECT * FROM doadores WHERE id_doador = $id";
    } else {
        echo "Tipo de usuário inválido.";
        exit;
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Nenhum registro encontrado.";
        exit;
    }
} else {
    echo "Usuário não está logado.";
    exit;
}
