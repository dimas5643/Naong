<?php
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $dtinicial = $conn->real_escape_string($_POST['dtinicial']);
    $dtfinal = $conn->real_escape_string($_POST['dtfinal']);

    // Insere os dados no banco sem o caminho da imagem
    $sql = "INSERT INTO `naong`.`banners` (`nome`, `dtinicial`, `dtfinal`)
            VALUES ('$nome', '$dtinicial', '$dtfinal')";

    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id; // Obtém o ID gerado

        // Lidar com o upload da imagem
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] == 0) {
            $target_dir = "img/banners/";
            $imageFileType = str_replace('image/', '', $_FILES['banner']['type']);
            $target_file = $target_dir . 'banner_' . $id . '.' . $imageFileType;

            $check = getimagesize($_FILES["banner"]["tmp_name"]);
            if ($check !== false) {
                if ($_FILES["banner"]["size"] <= 25000000) { // 25MB máximo
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                        if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
                            // Atualizar o caminho da imagem no banco de dados
                            $sql = "UPDATE `naong`.`banners` 
                                    SET `arquivo` = '$target_file' 
                                    WHERE `id_banner` = $id";

                            if ($conn->query($sql) === TRUE) {
                                echo "Arquivo enviado e caminho atualizado com sucesso!";
                            } else {
                                echo "Erro ao atualizar o caminho da imagem: " . $conn->error;
                            }
                        } else {
                            echo "Desculpe, houve um erro ao enviar sua imagem.";
                        }
                    } else {
                        echo "Desculpe, apenas arquivos JPG, JPEG e PNG são permitidos.";
                    }
                } else {
                    echo "Desculpe, seu arquivo é muito grande.";
                }
            } else {
                echo "O arquivo não é uma imagem.";
            }
        }
    } else {
        echo "Erro ao inserir os dados: " . $conn->error;
    }

    $conn->close();

    header('Location: cadastro_banner.php');
}


if (isset($_GET['id'])) {

    // Obtém o valor do ID
    $id_banner = $_GET['id'];

    $sql = "SELECT * FROM banners WHERE id_banner = $id_banner";
    $result_banner = $conn->query($sql);

    if ($result_banner->num_rows > 0) {
        $row = $result_banner->fetch_assoc();
    } else {
        echo "Nenhum registro encontrado.";
        exit;
    }
}