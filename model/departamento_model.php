<?php
include '../banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome =  strtoupper($_POST['nome']);
    $ativo = $_POST['ativo'];
    $icon = $_POST['icon'];

    // Proteção contra SQL Injection
    $nome = $conn->real_escape_string($nome);
    $ativo = $conn->real_escape_string($ativo);
    $icon = $conn->real_escape_string($icon);

    // Inserir dados no banco de dados com a data e hora atual no campo cadastro
    $sql = "INSERT INTO departamentos (nome_departamento, ativo, icon)
            VALUES ('$nome', 'A', '$icon')";

    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
