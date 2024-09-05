<?php

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redireciona para a página de cadastro
    header("Location: cadastro.php");
    exit(); // Encerra o script para garantir que o redirecionamento ocorra
}
