<?php
// Verifica se o usuário está logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
if (!isset($_SESSION['user_id'])) {
    // Define uma variável de sessão para indicar que o usuário foi redirecionado

    $_SESSION['login_redirect'] = true;
    // Redireciona para a página de login
    header("Location: login.php");
    exit();
}

