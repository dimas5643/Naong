<?php
include 'banco.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['senha'])) {
        header('Location: login.php?erro=1');
        exit;
    }
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
        if (password_verify($senha, $doador['senha'])) {
            // Senha correta
            $_SESSION['user_role'] = 'doador';
            $_SESSION['user_id'] = $doador['id_doador'];
            // Aqui você pode redirecionar o usuário para uma página específica
            header('Location: index.php');
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
            $_SESSION['user_role'] = 'ong';
            $_SESSION['user_id'] = $ong['id_ong'];
            // Aqui você pode redirecionar o usuário para uma página específica
            header('Location: index.php');
            exit();
        }
    }

    // Verificar credenciais na tabela adm
    $sql = "SELECT * FROM administradores WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado na tabela adm
        $adm = $result->fetch_assoc();

        if ($senha === $adm['senha']) {
            // Senha correta
            $_SESSION['user_role'] = 'adm';
            $_SESSION['user_id'] = $adm['id_administradores'];
            // Aqui você pode redirecionar o usuário para uma página específica
            header('Location: index.php');
            exit();
        }
    }

    // Se nenhum usuário for encontrado ou a senha estiver incorreta
    header('Location: login.php?erro=2');
    exit;
}

$conn->close();
