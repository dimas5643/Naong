<?php
include('./valida_login.php');
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos estão preenchidos
    if (empty($_POST['nome']) || empty($_POST['dtinicial']) || empty($_POST['dtfinal']) || empty($_FILES['banner']['name'])) {
        header('Location: cadastro_banner.php?erro=1');
        exit;
    }

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

            // Verifica se o arquivo é uma imagem válida
            $check = getimagesize($_FILES["banner"]["tmp_name"]);
            if ($check !== false) {
                // Verifica o tamanho da imagem (máximo 25MB)
                if ($_FILES["banner"]["size"] <= 25000000) {
                    // Verifica se o tipo de arquivo é permitido (JPG, JPEG, PNG)
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                        if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
                            // Atualizar o caminho da imagem no banco de dados
                            $sql = "UPDATE `naong`.`banners` 
                                    SET `arquivo` = '$target_file' 
                                    WHERE `id_banner` = $id";

                            if ($conn->query($sql) === TRUE) {
                                header("Location: cadastro_banner.php?id=$id");
                                exit;
                            } else {
                                header('Location: cadastro_banner.php?erro=2');
                                exit;
                            }
                        } else {
                            header('Location: cadastro_banner.php?erro=2');
                            exit;
                        }
                    } else {
                        // Tipo de arquivo não permitido
                        header('Location: cadastro_banner.php?erro=3');
                        exit;
                    }
                } else {
                    // Arquivo muito grande
                    header('Location: cadastro_banner.php?erro=4');
                    exit;
                }
            } else {
                // Arquivo não é uma imagem
                header('Location: cadastro_banner.php?erro=5');
                exit;
            }
        } else {
            // Erro no upload
            header('Location: cadastro_banner.php?erro=2');
            exit;
        }
    } else {
        header('Location: cadastro_banner.php?erro=6');
        exit;
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
        header('Location: cadastro_banner.php?erro=7');
        exit;
    }
}
