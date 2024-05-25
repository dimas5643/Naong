<?php
include 'banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Proteção contra SQL Injection
    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha);
    
    // Verificar credenciais na tabela doadores
    $sql = "SELECT * FROM doadores WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado na tabela doadores
        $doador = $result->fetch_assoc();

        /*echo "<pre>";
        print_r($doador);
        ECHO password_verify($senha, $doador['senha']);
        echo "<br>";
        echo $senha;
        echo "<br>";
        echo $doador;
        echo "<br>";
        echo password_hash($senha, PASSWORD_DEFAULT);*/

        if (password_verify($senha, $doador['senha'])) {
        //echo md5($senha);
        //echo "<br>";
        //echo md5($doador['senha']);
        //echo "<br>";   

        //if (md5($senha) == $doador['senha']) {

            // Senha correta
            echo "Login realizado com sucesso como Doador!";
            // Aqui você pode redirecionar o usuário para uma página específica
            exit();
        }
    }

    // Verificar credenciais na tabela ongs
    $sql = "SELECT * FROM ongs WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado na tabela ongs
        $ong = $result->fetch_assoc();
        if (password_verify($senha, $ong['senha'])) {
            // Senha correta
            echo "Login realizado com sucesso como ONG!";
            // Aqui você pode redirecionar o usuário para uma página específica
            exit();
        }
    }

    // Se nenhum usuário for encontrado ou a senha estiver incorreta
    echo "Email ou senha inválidos!";
}

$conn->close();
?>
