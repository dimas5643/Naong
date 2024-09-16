<?php
include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nome']) || empty($_POST['documento']) || empty($_POST['cep']) || empty($_POST['estado']) || empty($_POST['cidade']) || empty($_POST['endereco']) || empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['data_nascimento'])) {
        header('Location: cadastro.php?erro=1');
        exit;
    }

    $nome = $conn->real_escape_string($_POST['nome']);
    $documento = $conn->real_escape_string($_POST['documento']);
    $cep = $conn->real_escape_string($_POST['cep']);
    $estado = $conn->real_escape_string($_POST['estado']);
    $cidade = $conn->real_escape_string($_POST['cidade']);
    $endereco = $conn->real_escape_string($_POST['endereco']);
    $email = $conn->real_escape_string($_POST['email']);
    $celular = $conn->real_escape_string($_POST['celular']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $data_nascimento = $conn->real_escape_string($_POST['data_nascimento']);

    // Verificar se o CPF/CNPJ já existe na tabela doadores
    $sql_verifica_cpf = "SELECT cpf_cnpj FROM doadores WHERE cpf_cnpj = '$documento'
                        UNION
                        SELECT cnpj FROM Ongs WHERE cnpj = '$documento'";
    $resultado_cpf = $conn->query($sql_verifica_cpf);

    if ($resultado_cpf->num_rows > 0) {
        // CPF já está em uso
        header('Location: cadastro.php?erro=5'); // Erro 3 para CPF em uso
        exit;
    }

    // Verificar se o email já existe na tabela doadores ou Ongs
    $sql_verifica_email = "SELECT email FROM doadores WHERE email = '$email'
                           UNION
                           SELECT email FROM Ongs WHERE email = '$email'";
    $resultado_email = $conn->query($sql_verifica_email);

    if ($resultado_email->num_rows > 0) {
        // Email já está em uso
        header('Location: cadastro.php?erro=4'); // Erro 4 para email em uso
        exit;
    }

    // Verificar se o email já existe na tabela administradores
    $sql_verifica_email = "SELECT email FROM administradores WHERE email = '$email'";
    $resultado_email = $conn->query($sql_verifica_email);
    if ($resultado_email->num_rows > 0) {
        // Email já está em uso
        header('Location: cadastro.php?erro=4'); // Erro 4 para email em uso
        exit;
    }

    // Se o email e o CPF não estiverem em uso, prossegue com o cadastro
    $sql = "INSERT INTO doadores (nome, cpf_cnpj, cep, estado, cidade, endereco, email, telefone, senha, nascimento, cadastro, ativo)
            VALUES ('$nome', '$documento', '$cep', '$estado', '$cidade', '$endereco', '$email', '$celular', '$senha', '$data_nascimento', NOW(), 'A')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        header('Location: cadastro.php?erro=2');
        exit;
    }

    $conn->close();
}
