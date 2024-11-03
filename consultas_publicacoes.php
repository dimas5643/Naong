<?php


// Verifica se as coordenadas estão armazenadas na sessão
if (isset($_SESSION['location']['latitude']) && isset($_SESSION['location']['longitude'])) {
    $latitude = $_SESSION['location']['latitude'];
    $longitude = $_SESSION['location']['longitude'];
} else {
    // Faz uma requisição à API do ipinfo.io para obter a localização
    $ip_info = file_get_contents("http://ipinfo.io/json");

    // Verifica se a requisição foi bem-sucedida
    if ($ip_info === false) {
        die('Erro ao obter informações de localização.');
    }

    // Decodifica a resposta JSON
    $ip_data = json_decode($ip_info, true);

    // Pega as coordenadas de latitude e longitude
    $location = explode(',', $ip_data['loc']);
    $latitude = $location[0];
    $longitude = $location[1];

    // Armazena na sessão
    $_SESSION['location']['latitude'] = $latitude;
    $_SESSION['location']['longitude'] = $longitude;
}

// Conexão com o banco de dados (certifique-se de ter a variável $conn definida)
$sql_list_publicacoes = "SELECT 
                            publicacoes.*, 
                            ongs.nome_fantasia,
                            ( 6371 * acos( cos( radians($latitude) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(latitude) ) ) ) AS distance
                        FROM 
                            publicacoes 
                            INNER JOIN 
                            ongs 
                            ON 
                            publicacoes.id_ong = ongs.id_ong 
                        ORDER BY distance DESC LIMIT 3";

// Executa a consulta
$result_lits_publicacoes = $conn->query($sql_list_publicacoes);

// Verifica se a consulta retornou resultados
$list_publicacoes = $result_lits_publicacoes->fetch_all(MYSQLI_ASSOC);
