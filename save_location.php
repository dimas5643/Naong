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
    echo json_encode(['status' => 'error', 'message' => 'Dados de localização incompletos']);
}
?>
