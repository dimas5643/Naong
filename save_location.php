<?php
session_start();

// Obtém os dados de localização enviados pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['city'], $data['state'], $data['country'], $data['latitude'], $data['longitude'])) {
    // Salva os dados na sessão
    $_SESSION['location'] = [
        'city' => $data['city'],
        'state' => $data['state'],
        'country' => $data['country'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude']
    ];

    echo json_encode(['status' => 'success', 'message' => 'Localização salva com sucesso']);
} else {

    // Insira seu token do IPinfo
    $token = "14a37eb39aae75";  

    // Faz uma requisição à API do ipinfo.io com o token
    $ip_info = file_get_contents("http://ipinfo.io/json?token={$token}");
    if ($ip_info === false) {
        die(json_encode(['status' => 'error', 'message' => 'Erro ao obter informações de localização.']));
    }

    // Decodifica a resposta JSON
    $ip_data = json_decode($ip_info, true);

    // Verifica se a resposta contém dados esperados
    if (!isset($ip_data['loc'])) {
        die(json_encode(['status' => 'error', 'message' => 'Dados de localização não disponíveis.']));
    }

    // Pega as coordenadas de latitude e longitude
    $location = explode(',', $ip_data['loc']);
    $latitude = $location[0] ?? null;
    $longitude = $location[1] ?? null;

    $cidade = $ip_data['city'] ?? 'Desconhecido';
    $estado = $ip_data['region'] ?? 'Desconhecido';
    $pais = $ip_data['country'] ?? 'Desconhecido';

    // Verifica se latitude e longitude foram extraídas corretamente
    if ($latitude === null || $longitude === null) {
        die(json_encode(['status' => 'error', 'message' => 'Coordenadas não disponíveis.']));
    }

    // Armazena na sessão
    session_start();
    $_SESSION['location'] = [
        'city' => $cidade,
        'state' => $estado,
        'country' => $pais,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    // Retorna a resposta JSON para o cliente
    echo json_encode(['status' => 'success', 'message' => 'Localização salva com sucesso', 'data' => $_SESSION['location']]);
}
