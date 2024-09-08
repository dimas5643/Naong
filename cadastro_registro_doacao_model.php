<?php
include('./valida_login.php');
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_POST['doacao']) || empty($_POST['data']) || empty($_POST['ong'])) {
        header('Location: cadastro_registro_doacao.php?erro=1');
        exit;
    }
    $doacao = $conn->real_escape_string($_POST['doacao']);

    $data = $conn->real_escape_string($_POST['data']);
    $data = str_replace('T', ' ', $data);

    $ong = $conn->real_escape_string($_POST['ong']);

    $valor = $conn->real_escape_string($_POST['valor']);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);

    if (!$valor) {
        $valor = 0;
    }


    $user_id = $_SESSION['user_id'];
    $id_registro = $_POST['id_registro'] ?? null; // Recebe o ID do registro se estiver presente

    if (isset($_POST['acao']) && $_POST['acao'] === 'excluir' && isset($id_registro)) {
        // Excluir registro
        $sql_verificacao = "SELECT * FROM `naong`.`registro_doacoes` WHERE id_registro = $id_registro and id_doador = $user_id";

        $result_verificacao = $conn->query($sql_verificacao);

        if ($result_verificacao->num_rows > 0) {
            // Excluir
            $sql_delete = "DELETE FROM `naong`.`registro_doacoes` WHERE id_registro = $id_registro";
            $conn->query($sql_delete);
        } else {
            header('Location: cadastro_registro_doacao.php?erro=2');
            exit;
        }
    } else {
        if ($id_registro) {
            $sql_verificacao = "SELECT * FROM `naong`.`registro_doacoes` WHERE id_registro = $id_registro and id_doador = $user_id";
            $result_verificacao = $conn->query($sql_verificacao);

            if ($result_verificacao->num_rows > 0) {

                // Atualizar a registro existente
                $sql = "UPDATE `naong`.`registro_doacoes`
                        SET
                        `id_ong` = $ong,
                        `doacao` = '$doacao',
                        `data_doacao` = '$data',
                        `valor` = $valor
                        WHERE `id_registro` = $id_registro";
            } else {
                header('Location: cadastro_registro_doacao.php?erro=2');
                exit;
            }
        } else {
            // Inserir novo registro
            $sql = "INSERT INTO `naong`.`registro_doacoes`
                        (`id_registro`,
                        `id_doador`,
                        `id_ong`,
                        `doacao`,
                        `data_doacao`,
                        `valor`)
                        VALUES
                        (
                        NULL,
                        $user_id,
                        $ong,
                        '$doacao',
                        '$data',
                        $valor
                        );
                        ";
        }

        if ($conn->query($sql) === TRUE) {
            $id = $id_registro ? $id_registro : $conn->insert_id;
        } else {
            header('Location: cadastro_registro_doacao.php?erro=3');
            exit;
        }
    }

    $conn->close();

    if ($id) {
        header("Location: cadastro_registro_doacao.php?id_registro=$id");
    } else {
        header("Location: cadastro_registro_doacao.php");
    }
}


$user_id = $_SESSION['user_id'];
if (isset($_GET['id_registro'])) {
    // Obtém o valor do ID
    $id_registro = $_GET['id_registro'];


    //GET REGISTRO
    $sql = "SELECT * FROM registro_doacoes WHERE id_registro = $id_registro";
    $result_registro = $conn->query($sql);

    if ($result_registro->num_rows > 0) {
        $row = $result_registro->fetch_assoc();
    }else{
        header('Location: cadastro_banner.php?erro=4');
        exit;
    }
}

//LIST PONTOS DE COLETA SELECIIONADOS
$sql_list_ongs = "SELECT * FROM ongs WHERE ativo = 'A' order by nome_fantasia";
$result_list_ongs = $conn->query($sql_list_ongs);

$list_ongs = $result_list_ongs->fetch_all(MYSQLI_ASSOC);
