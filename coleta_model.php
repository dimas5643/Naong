<?php
session_start();
include './banco.php';

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $rua = $_POST['rua'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $pais = $_POST['pais'];
    $cep = $_POST['cep'];
    $numero_endereco = $_POST['numero_endereco'];
    $telefone = $_POST['telefone'];
    $ativo = $_POST['ativo'];

    // Proteção contra SQL Injection
    $ong = $conn->real_escape_string($id);
    $nome = $conn->real_escape_string($nome);
    $rua = $conn->real_escape_string($rua);
    $estado = $conn->real_escape_string($estado);
    $cidade = $conn->real_escape_string($cidade);
    $pais = $conn->real_escape_string($pais);
    $cep = $conn->real_escape_string($cep);
    $numero_endereco = $conn->real_escape_string($numero_endereco);
    $telefone = $conn->real_escape_string($telefone);
    $ativo = isset($_POST['ATIVO']) ? 'I' : 'A';

    $id_pontos_coleta = $_POST['id_pontos_coleta'] ?? null; // Recebe o ID do registro se estiver presente
    if (isset($_POST['acao']) && $_POST['acao'] === 'excluir' && isset($id_pontos_coleta)) {
        // Excluir registro
        $sql_verificacao = "SELECT * FROM `naong`.`pontos_coleta` WHERE id = $id_pontos_coleta and ong = $ong";
        $result_verificacao = $conn->query($sql_verificacao);

        if ($result_verificacao->num_rows > 0) {

            $sql_verificacao_publicacao = "SELECT * FROM `naong`.`publicacao_pontos_coleta` WHERE id_pontos_coleta = $id_pontos_coleta";
            $result_verificacao_publicacao = $conn->query($sql_verificacao_publicacao);

            if ($result_verificacao_publicacao->num_rows > 0) {
                echo "Esse ponto de coleta já está vinculado a uma publicação. Em vez de excluí-lo, inative-o para manter o histórico!";
            } else {
                // Excluir
                $sql_delete = "DELETE FROM `naong`.`pontos_coleta` WHERE id = $id_pontos_coleta";
                $conn->query($sql_delete);

                echo "Registro excluído com sucesso!";
            }
        } else {
            echo "Você não tem permissão para excluir essa registro.";
            die;
        }
    } else {
        $sql = "INSERT INTO `naong`.`pontos_coleta` (`ong`, `nome`, `rua`, `estado`, `cidade`, `pais`, `cep`, `numero_endereco`, `telefone`, `ativo`)  
            VALUES ('$ong', '$nome', '$rua',  '$estado', '$cidade', '$pais', '$cep', '$numero_endereco', '$telefone', '$ativo')";

        if ($conn->query($sql) === TRUE) {
            header("Location: consulta_coleta.php");
            exit;
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}

if (isset($_GET['id'])) {
    // Obtém o valor do ID
    $id = $_GET['id'];


    //GET REGISTRO
    $sql = "SELECT * FROM pontos_coleta WHERE id = $id";
    $result_registro = $conn->query($sql);

    if ($result_registro->num_rows > 0) {
        $row_pontos_coleta = $result_registro->fetch_assoc();
    }
}
