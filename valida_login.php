<?php

// Verifica se o usuário está logado
$usuarioLogado = true;
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redireciona para a página de cadastro
    $usuarioLogado = false;
    header("Location: login.php");
    exit(); // Encerra o script para garantir que o redirecionamento ocorra
}
