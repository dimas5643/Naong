<?php
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['documento']) || empty($_POST['cep']) || empty($_POST['estado']) || empty($_POST['cidade']) || empty($_POST['endereco']) || empty($_POST['contato']) || empty($_POST['email'])) {
        header('Location: perfil_ong.php?erro=1');
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
    $area_atuacao = $_POST['area_atuacao'];
    $id_deparamento = $_POST['departamento'];
    $descricao = $_POST['descricao'];
    $site = $_POST['site'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];

    // Proteção contra SQL Injection
    $nome = $conn->real_escape_string($nome);
    $documento = $conn->real_escape_string($documento);
    $cep = $conn->real_escape_string($cep);
    $estado = $conn->real_escape_string($estado);
    $cidade = $conn->real_escape_string($cidade);
    $endereco = $conn->real_escape_string($endereco);
    $contato = $conn->real_escape_string($contato);
    $email = $conn->real_escape_string($email);
    $area_atuacao = $conn->real_escape_string($area_atuacao);
    $id_deparamento = $conn->real_escape_string($id_deparamento);
    $descricao = $conn->real_escape_string($descricao);
    $site = $conn->real_escape_string($site);
    $instagram = $conn->real_escape_string($instagram);
    $facebook = $conn->real_escape_string($facebook);

    if (!$id_deparamento) {
        $id_deparamento = 'NULL';
    }

    // Verificar se uma nova senha foi fornecida e criptografá-la
    if (!empty($senha)) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE ongs SET nome_fantasia='$nome', cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email', senha='$senha', area_atuacao='$area_atuacao', id_departamento=$id_deparamento, descricao='$descricao', site='$site', instagram='$instagram', facebook='$facebook' WHERE id_ong=$id";
    } else {
        $sql = "UPDATE ongs SET nome_fantasia='$nome', cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email', area_atuacao='$area_atuacao', id_departamento=$id_deparamento, descricao='$descricao', site='$site', instagram='$instagram', facebook='$facebook' WHERE id_ong=$id";
    }

    // Lidar com o upload da imagem
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $target_dir = "img/ongs/";
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
                        $sql = "UPDATE ongs SET nome_fantasia='$nome', cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email', area_atuacao='$area_atuacao', foto_perfil='$target_file', id_departamento=$id_deparamento, descricao='$descricao', site='$site', instagram='$instagram', facebook='$facebook' WHERE id_ong=$id";
                    } else {
                        header("Location: perfil_ong.php?erro=2&id_ong=$id");
                        exit;
                    }
                } else {
                    header("Location: perfil_ong.php?erro=3&id_ong=$id");
                    exit;
                }
            } else {
                header("Location: perfil_ong.php?erro=4&id_ong=$id");
                exit;
            }
        } else {
            header("Location: perfil_ong.php?erro=5&id_ong=$id");
            exit;
        }
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: perfil_ong.php?id_ong=$id");
        exit;
    } else {
        header("Location: perfil_ong.php?erro=6&id_ong=$id");
        exit;
    }

    $conn->close();
}

header('Location: perfil_ong.php');
