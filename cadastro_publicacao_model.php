<?php

include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $dtpublicacao = new DateTime();
    $dtpublicacao = $dtpublicacao->format('Y-m-d H:i:s');

    if (isset($_POST['pontos_coleta']) && $_POST['pontos_coleta']) {
        $list_pontos_coleta = $_POST['pontos_coleta'];
    }



    $user_id = $_SESSION['user_id'];
    $id_publicacao = $_POST['id_publicacoes'] ?? null; // Recebe o ID da publicação se estiver presente

    if (isset($_POST['acao']) && $_POST['acao'] === 'excluir' && isset($id_publicacao)) {
        // Excluir publicação
        $sql_verificacao = "SELECT * FROM `naong`.`publicacoes` WHERE id_publicacoes = $id_publicacao and id_ong = $user_id";
        $result_verificacao = $conn->query($sql_verificacao);

        if ($result_verificacao->num_rows > 0) {
            // Excluir
            $sql_delete_pontos = "DELETE FROM `naong`.`publicacao_pontos_coleta` WHERE id_publicacao = $id_publicacao";
            $conn->query($sql_delete_pontos);

            $sql = "DELETE FROM `naong`.`publicacoes` WHERE id_publicacoes = $id_publicacao and id_ong = $user_id";
            $conn->query($sql);

            echo "Publicação excluída com sucesso!";
        } else {
            echo "Você não tem permissão para excluir essa publicação.";
            die;
        }
    } else {
        if ($id_publicacao) {
            $sql_verificacao = "SELECT * FROM `naong`.`publicacoes` WHERE id_publicacoes = $id_publicacao and id_ong = $user_id";
            $result_verificacao = $conn->query($sql_verificacao);

            if ($result_verificacao->num_rows > 0) {

                // Atualizar a publicação existente
                $sql = "UPDATE `naong`.`publicacoes` 
                SET `titulo` = '$titulo',
                    `descricao` = '$descricao',
                    `dtpublicacao` = '$dtpublicacao'
                WHERE `id_publicacoes` = $id_publicacao 
                  AND `id_ong` = $user_id";
            } else {
                echo 'Você não tem essa permissão';
                die;
            }
        } else {
            // Inserir nova publicação
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
                    );";
        }

        if ($conn->query($sql) === TRUE) {
            $id = $id_publicacao ? $id_publicacao : $conn->insert_id; // Se for uma atualização, mantém o ID, caso contrário, obtém o ID gerado

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

                                if ($conn->query($sql) !== TRUE) {
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
                // Excluir pontos de coleta antigos
                $sql_delete_publicacao_pontos_coleta = "DELETE FROM `naong`.`publicacao_pontos_coleta` WHERE id_publicacao = $id";
                $conn->query($sql_delete_publicacao_pontos_coleta);

                // Inserir novos pontos de coleta
                foreach ($list_pontos_coleta as $pontos_coleta) {
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
            echo "Erro ao inserir/atualizar os dados: " . $conn->error;
        }
    }

    $conn->close();

    header("Location: cadastro_publicacao.php?id_publicacao=$id");
}


$user_id = $_SESSION['user_id'];
if (isset($_GET['id_publicacao'])) {
    // Obtém o valor do ID
    $id_publicacao = $_GET['id_publicacao'];


    //GET PUBLICAÇÃO
    $sql = "SELECT * FROM publicacoes WHERE id_publicacoes = $id_publicacao";
    $result_publicacao = $conn->query($sql);

    if ($result_publicacao->num_rows > 0) {
        $row = $result_publicacao->fetch_assoc();
    }

    $sql_publicacao_pontos_coleta = "SELECT pc.id, pc.nome FROM publicacao_pontos_coleta ppc inner join pontos_coleta pc on ppc.id_pontos_coleta = pc.id WHERE ppc.id_publicacao = $id_publicacao";
    $result_publicacao_pontos_coleta = $conn->query($sql_publicacao_pontos_coleta);
    $list_publicacao_pontos_coleta = $result_publicacao_pontos_coleta->fetch_all(MYSQLI_ASSOC);
}

//LIST PONTOS DE COLETA SELECIIONADOS
$sql_pontos_coleta = "SELECT * FROM pontos_coleta WHERE ong = $user_id and ativo = 'A'";
$result_pontos_coleta = $conn->query($sql_pontos_coleta);


$list_pontos_coleta = $result_pontos_coleta->fetch_all(MYSQLI_ASSOC);
