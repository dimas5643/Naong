<?php
session_start();

// Verificar se o usuário está logado e obter o ID e o tipo de usuário da sessão
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    $id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Determinar a tabela correta com base no tipo de usuário
    if ($user_role == 'ong') {
        $sql_ong = "SELECT * FROM ongs WHERE id_ong = $id";
        $sql_list_publicacoes = "SELECT * FROM publicacoes where id_ong = $id ORDER BY id_publicacoes DESC LIMIT 3";
        $sql_list_departamentos = "SELECT * FROM departamentos where ativo = 'A'";
    } elseif ($user_role == 'doador') {
        $sql = "SELECT * FROM doadores WHERE id_doador = $id";
    } else {
        echo "Tipo de usuário inválido.";
        exit;
    }

    $result_ong = $conn->query($sql_ong);

    if ($result_ong->num_rows > 0) {
        $row = $result_ong->fetch_assoc();

        $result_list_publicacoes = $conn->query($sql_list_publicacoes);
        $list_publicacoes = $result_list_publicacoes->fetch_all(MYSQLI_ASSOC);

        $result_list_departamentos = $conn->query($sql_list_departamentos);
        $list_departamentos = $result_list_departamentos->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Nenhum registro encontrado.";
        exit;
    }
} else {
    echo "Usuário não está logado.";
    exit;
}
