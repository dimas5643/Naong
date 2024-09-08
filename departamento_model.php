<?php
include('./valida_login.php');
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_departamento =  strtoupper($_POST['id_departamento']);
    $nome =  strtoupper($_POST['nome']);
    $ativo = 'I';
    if (isset($_POST['ativo'])) {
        $ativo = 'A';
    }

    $icon = $_POST['icon'];

    // Proteção contra SQL Injection
    $nome = $conn->real_escape_string($nome);
    $ativo = $conn->real_escape_string($ativo);
    $icon = $conn->real_escape_string($icon);

    // Inserir dados no banco de dados com a data e hora atual no campo cadastro
    if ($id_departamento) {
        $sql = "UPDATE departamentos SET nome_departamento = '$nome', ativo = '$ativo', icon = '$icon' WHERE id_departamento = $id_departamento";
    } else {
        $sql = "INSERT INTO departamentos (nome_departamento, ativo, icon)
            VALUES ('$nome', '$ativo', '$icon')";
    }


    if ($conn->query($sql) === TRUE) {
        include './lista_departamento.php';
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

if (isset($_GET['id'])) {

    // Obtém o valor do ID
    $id_departamento = $_GET['id'];

    $sql = "SELECT * FROM departamentos WHERE id_departamento = $id_departamento";
    $result_departamento = $conn->query($sql);
    if ($result_departamento) {
        $getDepartamento = $result_departamento->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Erro: " . $conn->error;
    }
}
