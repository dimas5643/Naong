<?php
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            // Verificar se o arquivo já existe
            if (!file_exists($target_file)) {
                // Verificar o tamanho do arquivo
                if ($_FILES["foto_perfil"]["size"] <= 5000000) { // 5MB máximo
                    // Permitir apenas certos formatos de arquivo
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
                            // Atualizar o caminho da imagem no banco de dados
                            $sql = "UPDATE doadores SET nome='$nome', cpf_cnpj='$documento', cep='$cep', estado='$estado', cidade='$cidade', endereco='$endereco', telefone='$contato', email='$email', foto_perfil='$target_file' WHERE id_doador=$id";
                        } else {
                            echo "Desculpe, houve um erro ao enviar sua imagem.";
                        }
                    } else {
                        echo "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                    }
                } else {
                    echo "Desculpe, seu arquivo é muito grande.";
                }
            } else {
                echo "Desculpe, o arquivo já existe.";
            }
        } else {
            echo "O arquivo não é uma imagem.";
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo "Atualização realizada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

header('Location: perfil_doador.php');
