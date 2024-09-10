<?php
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['documento']) || empty($_POST['cep']) || empty($_POST['estado']) || empty($_POST['cidade']) || empty($_POST['endereco']) || empty($_POST['email'])) {
        header('Location: perfil_doador.php?erro=1');
        exit;
    }
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $documento = $_POST['documento'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $contato = $_POST['contato'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Proteção contra SQL Injection
    $nome = $conn->real_escape_string($nome);
    $documento = $conn->real_escape_string($documento);
    $cep = $conn->real_escape_string($cep);
    $estado = $conn->real_escape_string($estado);
    $cidade = $conn->real_escape_string($cidade);
    $endereco = $conn->real_escape_string($endereco);
    $contato = $conn->real_escape_string($contato);
    $email = $conn->real_escape_string($email);

    // Verificar se uma nova senha foi fornecida e criptografá-la
    if (!empty($senha)) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE doadores SET nome='$nome', cpf_cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email', senha='$senha' WHERE id_doador=$id";
    } else {
        $sql = "UPDATE doadores SET nome='$nome', cpf_cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email' WHERE id_doador=$id";
    }

    // Lidar com o upload da imagem
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $target_dir = "img/doadores/";
        $imageFileType = str_replace('image/', '', $_FILES['foto_perfil']['type']);
        $target_file = $target_dir . 'ong_' . $id . '.' . $imageFileType;

        // Verificar se o arquivo é uma imagem
        $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
        if ($check !== false) {
            // Verificar o tamanho do arquivo
            if ($_FILES["foto_perfil"]["size"] <= 5000000) { // 5MB máximo
                // Permitir apenas certos formatos de arquivo
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                    if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
                        // Atualizar o caminho da imagem no banco de dados
                        $sql = "UPDATE doadores SET nome='$nome', cpf_cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email', foto_perfil='$target_file' WHERE id_doador=$id";
                    } else {
                        header("Location: perfil_doador.php?erro=2");
                        exit;
                    }
                } else {
                    header("Location: perfil_doador.php?erro=3");
                    exit;
                }
            } else {
                header("Location: perfil_doador.php?erro=4");
                exit;
            }
        } else {
            header("Location: perfil_doador.php?erro=5");
            exit;
        }
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: perfil_doador.php");
        exit;
    } else {
        header("Location: perfil_doador.php?erro=6");
        exit;
    }

    $conn->close();
}

header('Location: perfil_doador.php');
