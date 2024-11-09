<?php
include './banco.php';

// Função para obter as coordenadas
function getCoordinates($endereco, $cidade, $estado)
{
    $apiKey = 'AIzaSyB-N9uCpQNAjSVptM-LjXOCmfS19UZiPhs';
    $address = urlencode($endereco . ', ' . $cidade . ', ' . $estado);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apiKey}";

    $response = file_get_contents($url);
    $response = json_decode($response, true);

    if ($response['status'] == 'OK') {
        $latitude = $response['results'][0]['geometry']['location']['lat'];
        $longitude = $response['results'][0]['geometry']['location']['lng'];
        return array('latitude' => $latitude, 'longitude' => $longitude);
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['documento-ong']) || empty($_POST['cep']) || empty($_POST['estado']) || empty($_POST['cidade']) || empty($_POST['endereco']) || empty($_POST['contato']) || empty($_POST['email']) || empty($_POST['senha'])) {
        header('Location: cadastro.php?erro=1');
        exit;
    }
    $nome = $_POST['nome'];
    $documento = $_POST['documento-ong'];
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
    $senha = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

    // Verificar se o CPF/CNPJ já existe na tabela doadores
    $sql_verifica_cpf = "SELECT cpf_cnpj FROM doadores WHERE cpf_cnpj = '$documento'
    UNION
    SELECT cnpj FROM Ongs WHERE cnpj = '$documento'";
    $resultado_cpf = $conn->query($sql_verifica_cpf);

    if ($resultado_cpf->num_rows > 0) {
        // CPF já está em uso
        header('Location: cadastro.php?erro=5'); // Erro 3 para CPF em uso
        exit;
    }

    // Verificar se o email já existe na tabela doadores ou Ongs
    $sql_verifica_email = "SELECT email FROM doadores WHERE email = '$email'
            UNION
            SELECT email FROM Ongs WHERE email = '$email'";
    $resultado_email = $conn->query($sql_verifica_email);

    if ($resultado_email->num_rows > 0) {
        // Email já está em uso
        header('Location: cadastro.php?erro=4'); // Erro 4 para email em uso
        exit;
    }
    // Verificar se o email já existe na tabela administradores
    $sql_verifica_email = "SELECT email FROM administradores WHERE email = '$email'";
    $resultado_email = $conn->query($sql_verifica_email);
    if ($resultado_email->num_rows > 0) {
        // Email já está em uso
        header('Location: cadastro.php?erro=4'); // Erro 4 para email em uso
        exit;
    }

    // Obtém as coordenadas
    $sql_cidade = "SELECT nome FROM cidades WHERE id = '$cidade'";
    $resultado_cidade = $conn->query($sql_cidade);
    $nome_cidade = $resultado_cidade->fetch_all(MYSQLI_ASSOC);

    $sql_estado = "SELECT nome FROM estados WHERE id = '$estado'";
    $resultado_estado = $conn->query($sql_estado);
    $nome_estado = $resultado_estado->fetch_all(MYSQLI_ASSOC);


    $coordenadas = getCoordinates($endereco, $nome_cidade[0]['nome'], $nome_estado[0]['nome']);

    if ($coordenadas) {
        $latitude = $coordenadas['latitude'];
        $longitude = $coordenadas['longitude'];

        // Inserir dados no banco de dados com a data e hora atual no campo cadastro
        $sql = "INSERT INTO ongs (nome_fantasia, cnpj, cep, estado, cidade, endereco, telefone, email, senha, latitude, longitude, data_cadastro, ativo)
                VALUES ('$nome', '$documento', '$cep', '$estado', '$cidade', '$endereco', '$contato', '$email', '$senha', '$latitude', '$longitude', NOW(), 'A')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
        } else {
            header('Location: cadastro.php?erro=2');
            exit;
        }
    } else {
        header('Location: cadastro.php?erro=3');
        exit;
    }

    $conn->close();
}
