<?php

$sql_list_publicacoes = "SELECT publicacoes.*, ongs.nome_fantasia FROM publicacoes inner join ongs on publicacoes.id_ong = ongs.id_ong ORDER BY id_publicacoes DESC LIMIT 3";
$result_lits_publicacoes = $conn->query($sql_list_publicacoes);
$list_publicacoes = $result_lits_publicacoes->fetch_all(MYSQLI_ASSOC);
