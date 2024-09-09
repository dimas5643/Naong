<?php
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $documento = $_POST['documento'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $senha = $_POST['senha'];
    $data_nascimento = $_POST['data_nascimento'];

    // Proteção contra SQL Injection
    $nome = $conn->real_escape_string($nome);
    $documento = $conn->real_escape_string($documento);
    $cep = $conn->real_escape_string($cep);
    $estado = $conn->real_escape_string($estado);
    $cidade = $conn->real_escape_string($cidade);
    $endereco = $conn->real_escape_string($endereco);
    $email = $conn->real_escape_string($email);
    $celular = $conn->real_escape_string($celular);
    $senha = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

    $data_nascimento = $conn->real_escape_string($data_nascimento);

    $sql = "INSERT INTO doadores (nome, cpf_cnpj, cep, estado, cidade, endereco, email, telefone, senha, nascimento, cadastro, ativo)
            VALUES ('$nome', '$documento', '$cep', '$estado', '$cidade', '$endereco', '$email', '$celular', '$senha', '$data_nascimento', NOW(), 'A')";

    if ($conn->query($sql) === TRUE) {
        
        header("Location: login.php");
        //DIRECIONAR PARA A PAGINA PRINCIPAL 
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
