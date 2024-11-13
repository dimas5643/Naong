<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$mostraCampo = false;
$disabled = 'disabled';

if (isset($_GET['id_ong'])) {

    $id_ong = $_GET['id_ong'];
    $user_role = '';
    if (isset($_SESSION['user_role'])) {
        $user_role = $_SESSION['user_role'];
    }


    $sql_ong = "SELECT ongs.*, departamentos.nome_departamento, departamentos.icon FROM ongs  left join departamentos on ongs.id_departamento = departamentos.id_departamento WHERE id_ong = ?";
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

                
                $nome_cidade = getNomeCidade($conn, $row['cidade']);
                $nome_estado = getNomeEstado($conn, $row['estado']);


                // Executar consultas adicionais se o perfil for encontrado
                if (isset($sql_list_publicacoes)) {
                    $list_publicacoes = listPublicacao($conn, $id_ong, $sql_list_publicacoes);
                }

                if (isset($sql_list_departamentos)) {
                    $list_departamentos = listDepartamento($conn, $sql_list_departamentos);
                }


                if ($user_role == 'ong' && $_SESSION['user_id'] == $row['id_ong']) {
                    $mostraCampo = true;
                    $disabled = '';
                }
            } else {
                header("Location: perfil_ong.php?erro=7&id_ong=$id_ong");
                exit;
            }
        } else {
            header("Location: perfil_ong.php?erro=7&id_ong=$id_ong");
            exit;
        }
    } else {
        header("Location: perfil_ong.php?erro=7&id_ong=$id_ong");
        exit;
    }
} else if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) { // Verificar se o usuário está logado e obter o ID e o tipo de usuário da sessão
    $id_ong = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Determinar a tabela correta com base no tipo de usuário
    if ($user_role == 'ong') {
        $sql_ong = "SELECT ongs.*, departamentos.nome_departamento, departamentos.icon FROM ongs  left join departamentos on ongs.id_departamento = departamentos.id_departamento WHERE id_ong = ?";
        $sql_list_publicacoes = "SELECT * FROM publicacoes WHERE id_ong = ? ORDER BY id_publicacoes DESC LIMIT 3";
        $sql_list_departamentos = "SELECT * FROM departamentos WHERE ativo = 'A'";
    } elseif ($user_role == 'doador') {
        $sql_ong = "SELECT * FROM doadores WHERE id_doador = ?";
    } else {
        header("Location: perfil_ong.php?erro=8&id_ong=$id_ong");
        exit;
    }

    // Preparar e executar a consulta para obter os dados do perfil
    if (isset($sql_ong)) {
        $stmt = $conn->prepare($sql_ong);
        $stmt->bind_param('i', $id_ong); // 'i' para inteiro
        if ($stmt->execute()) {
            $result_ong = $stmt->get_result();
            if ($result_ong->num_rows > 0) {
                $row = $result_ong->fetch_assoc();

                $nome_cidade = getNomeCidade($conn, $row['cidade']);
                $nome_estado = getNomeEstado($conn, $row['estado']);

                if ($user_role == 'ong' && $_SESSION['user_id'] == $row['id_ong']) {
                    $mostraCampo = true;
                    $disabled = '';
                }
                // Executar consultas adicionais se o perfil for encontrado
                if (isset($sql_list_publicacoes)) {
                    $list_publicacoes = listPublicacao($conn, $id_ong, $sql_list_publicacoes);
                }

                if (isset($sql_list_departamentos)) {
                    $list_departamentos = listDepartamento($conn, $sql_list_departamentos);
                }
            } else {
                header("Location: perfil_ong.php?erro=7&id_ong=$id_ong");
                exit;
            }
        } else {
            header("Location: perfil_ong.php?erro=7&id_ong=$id_ong");
            exit;
        }
    } else {
        header("Location: perfil_ong.php?erro=7&id_ong=$id_ong");
        exit;
    }
}

function listPublicacao($conn, $id_ong, $sql_list_publicacoes)
{
    $stmt_publicacoes = $conn->prepare($sql_list_publicacoes);
    $stmt_publicacoes->bind_param('i', $id_ong);
    $stmt_publicacoes->execute();
    $result_list_publicacoes = $stmt_publicacoes->get_result();
    return $list_publicacoes = $result_list_publicacoes->fetch_all(MYSQLI_ASSOC);
}

function listDepartamento($conn, $sql_list_departamentos)
{
    $result_list_departamentos = $conn->query($sql_list_departamentos);
    return $list_departamentos = $result_list_departamentos->fetch_all(MYSQLI_ASSOC);
}

function getNomeCidade($conn, $id_cidade)
{
    $sql_get_cidade = "SELECT nome FROM cidades where id = $id_cidade";
    $result_list_departamentos = $conn->query($sql_get_cidade);
    $getNomeCidade = $result_list_departamentos->fetch_all(MYSQLI_ASSOC);
    return $getNomeCidade = $getNomeCidade['nome'];
}

function getNomeEstado($conn, $id_estado)
{

    $sql_get_estado = "SELECT nome FROM estados where id = $id_estado";
    $result_list_departamentos = $conn->query($sql_get_estado);
    $getNomeEstado = $result_list_departamentos->fetch_all(MYSQLI_ASSOC);
    return $getNomeEstado = $getNomeEstado['nome'];
}
