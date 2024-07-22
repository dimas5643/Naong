<?php
include 'banco.php';

$sql = "SELECT * FROM departamentos WHERE ativo = 'A'";
$result_departamento = $conn->query($sql);
$listDepartamento = $result_departamento->fetch_all(MYSQLI_ASSOC);

