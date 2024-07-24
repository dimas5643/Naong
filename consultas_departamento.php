<?php
include 'banco.php';

$sql_departamentos_ativos = "SELECT * FROM departamentos WHERE ativo = 'A' ORDER BY nome_departamento";
$result_departamento_ativos = $conn->query($sql_departamentos_ativos);
$listDepartamentoAtivos = $result_departamento_ativos->fetch_all(MYSQLI_ASSOC);



$sql_departamentos_todos = "SELECT * FROM departamentos  ORDER BY nome_departamento";
$result_departamento_todos = $conn->query($sql_departamentos_todos);
$listDepartamentoTodos = $result_departamento_todos->fetch_all(MYSQLI_ASSOC);

