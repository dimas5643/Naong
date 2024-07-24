<?php
include 'banco.php';

$sql = "SELECT * FROM ongs";
$result_ongs = $conn->query($sql);
$listOngs = $result_ongs->fetch_all(MYSQLI_ASSOC);

