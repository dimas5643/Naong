<?php
include './banco.php';

// Função para obter as coordenadas
function getCoordinates($endereco, $cidade, $estado) {
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
    $senha = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

    // Obtém as coordenadas
    $coordenadas = getCoordinates($endereco, $cidade, $estado);

    if ($coordenadas) {
        $latitude = $coordenadas['latitude'];
        $longitude = $coordenadas['longitude'];

        // Inserir dados no banco de dados com a data e hora atual no campo cadastro
        $sql = "INSERT INTO ongs (nome_fantasia, cnpj, cep, estado, cidade, endereco, telefone, email, senha, latitude, longitude, data_cadastro, ativo)
                VALUES ('$nome', '$documento', '$cep', '$estado', '$cidade', '$endereco', '$contato', '$email', '$senha', '$latitude', '$longitude', NOW(), 'A')";

        if ($conn->query($sql) === TRUE) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erro ao obter as coordenadas do endereço.";
    }

    $conn->close();
}
?>
