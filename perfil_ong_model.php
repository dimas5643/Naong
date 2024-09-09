<?php
session_start();

$mostraCampo = false;
$disabled = 'disabled';

if (isset($_GET['id_ong'])) {
    $id_ong = $_GET['id_ong'];

    $sql_ong = "SELECT * FROM ongs WHERE id_ong = ?";
    $sql_list_publicacoes = "SELECT * FROM publicacoes WHERE id_ong = ? ORDER BY id_publicacoes DESC LIMIT 3";
    $sql_list_departamentos = "SELECT * FROM departamentos WHERE ativo = 'A'";


    // Preparar e executar a consulta para obter os dados do perfil
    if (isset($sql_ong)) {
        $stmt = $conn->prepare($sql_ong);
        $stmt->bind_param('i', $id_ong); // 'i' para inteiro
        if ($stmt->execute()) {
            $result_ong = $stmt->get_result();
            if ($result_ong->num_rows > 0) {
                $row = $result_ong->fetch_assoc();

                // Executar consultas adicionais se o perfil for encontrado
                if (isset($sql_list_publicacoes)) {
                    $list_publicacoes = listPublicacao($conn, $id, $sql_list_publicacoes);
                }

                if (isset($sql_list_departamentos)) {
                    $list_departamentos = listDepartamento($conn, $sql_list_departamentos);
                }


                if ($_SESSION['user_role'] == 'ong' && $_SESSION['user_id'] == $row['id_ong']) {
                    $mostraCampo = true;
                    $disabled = '';
                }
            } else {
                echo "Nenhum registro encontrado.";
                exit;
            }
        } else {
            echo "Erro ao executar a consulta: " . $conn->error;
            exit;
        }
    } else {
        echo "Consulta SQL não definida.";
        exit;
    }
} else if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) { // Verificar se o usuário está logado e obter o ID e o tipo de usuário da sessão
    $id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Determinar a tabela correta com base no tipo de usuário
    if ($user_role == 'ong') {
        $sql_ong = "SELECT * FROM ongs WHERE id_ong = ?";
        $sql_list_publicacoes = "SELECT * FROM publicacoes WHERE id_ong = ? ORDER BY id_publicacoes DESC LIMIT 3";
        $sql_list_departamentos = "SELECT * FROM departamentos WHERE ativo = 'A'";
    } elseif ($user_role == 'doador') {
        $sql_ong = "SELECT * FROM doadores WHERE id_doador = ?";
    } else {
        echo "Tipo de usuário inválido.";
        exit;
    }

    // Preparar e executar a consulta para obter os dados do perfil
    if (isset($sql_ong)) {
        $stmt = $conn->prepare($sql_ong);
        $stmt->bind_param('i', $id); // 'i' para inteiro
        if ($stmt->execute()) {
            $result_ong = $stmt->get_result();
            if ($result_ong->num_rows > 0) {
                $row = $result_ong->fetch_assoc();

                if ($_SESSION['user_role'] == 'ong' && $_SESSION['user_id'] == $row['id_ong']) {
                    $mostraCampo = true;
                    $disabled = '';
                }
                // Executar consultas adicionais se o perfil for encontrado
                if (isset($sql_list_publicacoes)) {
                    $list_publicacoes = listPublicacao($conn, $id, $sql_list_publicacoes);
                }

                if (isset($sql_list_departamentos)) {
                    $list_departamentos = listDepartamento($conn, $sql_list_departamentos);
                }
            } else {
                echo "Nenhum registro encontrado.";
                exit;
            }
        } else {
            echo "Erro ao executar a consulta: " . $conn->error;
            exit;
        }
    } else {
        echo "Consulta SQL não definida.";
        exit;
    }
} else {
    echo "Usuário não está logado.";
    exit;
}

function listPublicacao($conn, $id, $sql_list_publicacoes)
{
    $stmt_publicacoes = $conn->prepare($sql_list_publicacoes);
    $stmt_publicacoes->bind_param('i', $id);
    $stmt_publicacoes->execute();
    $result_list_publicacoes = $stmt_publicacoes->get_result();
    return $list_publicacoes = $result_list_publicacoes->fetch_all(MYSQLI_ASSOC);
}

function listDepartamento($conn, $sql_list_departamentos){
    $result_list_departamentos = $conn->query($sql_list_departamentos);
    return $list_departamentos = $result_list_departamentos->fetch_all(MYSQLI_ASSOC);
}
