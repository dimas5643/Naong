<?php

$dtAtual = date('Y-m-d');

$sql_list_banners = "SELECT * FROM banners WHERE (dtinicial < '$dtAtual' and dtfinal > '$dtAtual') or padrao = 'S' ORDER BY dtinicial";

$result_lits_banners = $conn->query($sql_list_banners);
$list_banners = $result_lits_banners->fetch_all(MYSQLI_ASSOC);
