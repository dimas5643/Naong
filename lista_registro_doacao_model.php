<?php
include 'banco.php';

$id_doador = $_SESSION['user_id'];

$sql_list_registro = "SELECT rd.*, o.nome_fantasia FROM registro_doacoes rd inner join ongs o on o.id_ong = rd.id_ong WHERE id_doador = $id_doador ORDER BY id_registro DESC LIMIT 10";
$result_list_registro = $conn->query($sql_list_registro);
$list_registros = $result_list_registro->fetch_all(MYSQLI_ASSOC);
