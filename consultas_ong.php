<?php
include 'banco.php';


if (isset($_SESSION['latitude']) && isset($_SESSION['longitude'])) {
    $latitude = $_SESSION['latitude'];
    $longitude = $_SESSION['longitude'];
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
}

$stmt = $conn->prepare("
    SELECT 
        id_ong,
        nome_fantasia,
        latitude,
        longitude,
        endereco,
        ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance
    FROM 
        ongs
    ORDER BY 
        distance ASC
    LIMIT 8;
");
$stmt->bind_param("ddd", $latitude, $longitude, $latitude);
$stmt->execute();
$result_ongs = $stmt->get_result();
$listOngs = $result_ongs->fetch_all(MYSQLI_ASSOC);
