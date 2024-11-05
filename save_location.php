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

    // Faz uma requisição à API do ipinfo.io
    $ip_info = file_get_contents("http://ipinfo.io/json");
    if ($ip_info === false) {
        die('Erro ao obter informações de localização.');
    }
    $ip_data = json_decode($ip_info, true);

    // Pega as coordenadas de latitude e longitude
    $location = explode(',', $ip_data['loc']);
    $latitude = $location[0];
    $longitude = $location[1];

    $cidade = $ip_data['city'] ?? 'Desconhecido';
    $estado = $ip_data['region'] ?? 'Desconhecido';
    $pais = $ip_data['country'] ?? 'Desconhecido';

    // Armazena na sessão
    $_SESSION['location'] = [
        'city' => $cidade,
        'state' => $estado,
        'country' => $cidade,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    if ($_SESSION['location']) {
        echo json_encode(['status' => 'success', 'message' => 'Localização salva com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados de localização incompletos']);
    }
}
