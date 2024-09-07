<?php

include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $dtpublicacao = new DateTime();
    $dtpublicacao = $dtpublicacao->format('Y-m-d H:i:s');

    if (isset($_POST['pontos_coleta']) && $_POST['pontos_coleta']) {
        $list_pontos_coleta = $_POST['pontos_coleta'];
    }


    $user_id = $_SESSION['user_id'];

    // Insere os dados no banco sem o caminho da imagem
    $sql = "INSERT INTO `naong`.`publicacoes`
                (`id_publicacoes`,
                `id_ong`,
                `titulo`,
                `descricao`,
                `dtpublicacao`)
                VALUES
                (
                NULL,
                $user_id,
                '$titulo',
                '$descricao',
                '$dtpublicacao'
                );
            ";


    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id; // Obtém o ID gerado

        // Lidar com o upload da imagem
        if (isset($_FILES['foto']) && $_FILES['foto'] && $_FILES['foto']['error'] == 0) {
            $target_dir = "img/publicacoes/";
            $imageFileType = str_replace('image/', '', $_FILES['foto']['type']);
            $target_file = $target_dir . 'publicacao_' . $id . '.' . $imageFileType;

            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check !== false) {
                if ($_FILES["foto"]["size"] <= 25000000) { // 25MB máximo
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                            // Atualizar o caminho da imagem no banco de dados
                            $sql = "UPDATE `naong`.`publicacoes` 
                                    SET `arquivo` = '$target_file' 
                                    WHERE `id_publicacoes` = $id";

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

        if (isset($_POST['pontos_coleta']) && $_POST['pontos_coleta']) {
            //SALVA OS PONTOS DE COLETA
            foreach ($list_pontos_coleta as $key => $pontos_coleta) {
                $sql = "INSERT INTO `naong`.`publicacao_pontos_coleta`
                    (`id_pontos_coleta`,
                    `id_publicacao`)
                    VALUES
                    (
                        $pontos_coleta,
                        $id
                    );";

                if ($conn->query($sql) !== TRUE) {
                    echo "Erro ao inserir os dados: " . $conn->error;
                }
            }
        }
    } else {
        echo "Erro ao inserir os dados: " . $conn->error;
    }

    $conn->close();

    header('Location: cadastro_publicacao.php');
}


if (isset($_GET['id_publicacao'])) {
    // Obtém o valor do ID
    $id_publicacao = $_GET['id_publicacao'];
    $user_id = $_SESSION['user_id'];

    //GET PUBLICAÇÃO
    $sql = "SELECT * FROM publicacoes WHERE id_publicacoes = $id_publicacao";
    $result_publicacao = $conn->query($sql);

    if ($result_publicacao->num_rows > 0) {
        $row = $result_publicacao->fetch_assoc();
    }

    $sql_publicacao_pontos_coleta = "SELECT pc.id, pc.nome FROM publicacao_pontos_coleta ppc inner join pontos_coleta pc on ppc.id_pontos_coleta = pc.id WHERE ppc.id_publicacao = $id_publicacao";
    $result_publicacao_pontos_coleta = $conn->query($sql_publicacao_pontos_coleta);
    $list_publicacao_pontos_coleta = $result_publicacao_pontos_coleta->fetch_all(MYSQLI_ASSOC);


    //LIST PONTOS DE COLETA SELECIIONADOS
    $sql_pontos_coleta = "SELECT * FROM pontos_coleta WHERE ong = $user_id and ativo = 'A'";
    $result_pontos_coleta = $conn->query($sql_pontos_coleta);


    $list_pontos_coleta = $result_pontos_coleta->fetch_all(MYSQLI_ASSOC);
}
