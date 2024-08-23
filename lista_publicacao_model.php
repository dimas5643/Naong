<?php
include 'banco.php';

$sql_list_publicacoes = "SELECT p.*, o.nome_fantasia FROM publicacoes p inner join ongs o on o.id_ong = p.id_ong ORDER BY id_publicacoes DESC LIMIT 10";
$result_list_publicacoes = $conn->query($sql_list_publicacoes);
$list_publicacoes = $result_list_publicacoes->fetch_all(MYSQLI_ASSOC);
