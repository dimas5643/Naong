<?php
include 'banco.php';

session_start();
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

    // Armazena na sessão
    $_SESSION['latitude'] = $latitude;
    $_SESSION['longitude'] = $longitude;
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
    HAVING 
        distance < 50   
    ORDER BY 
        distance ASC
    LIMIT 8;
");
$stmt->bind_param("ddd", $latitude, $longitude, $latitude);
$stmt->execute();
$result_ongs = $stmt->get_result();
$listOngs = $result_ongs->fetch_all(MYSQLI_ASSOC);
