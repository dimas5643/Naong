<?php
$acesso_telas_ongs = [
    'cadastro_publicacao.php',
    'cadastro.php',
    'coleta.php',
    'consulta_coleta.php',
    'lista_publicacao.php',
    'login.php',
    'logout.php',
    'perfil_ong.php',
    'pesquisa_mapa.php',
    'pesquisa_ongs.php'
];

$acesso_telas_doador = [
    'cadastro_registro_doacao.php',
    'cadastro.php',
    'lista_publicacao.php',
    'lista_registro_doacao.php',
    'login.php',
    'logout.php',
    'perfil_doador.php',
    'perfil_ong.php',
    'pesquisa_mapa',
    'pesquisa_ongs.php'
];

$paginaAtual = basename($_SERVER['PHP_SELF']);

$tipoUsuario = $_SESSION['user_role'];

if ($tipoUsuario == 'ong' && !in_array($paginaAtual, $acesso_telas_ongs)) {
    // Se for ONG e não tiver permissão para acessar a página, redireciona
    header("Location: login.php?erro=3");
    exit();
} elseif ($tipoUsuario == 'doador' && !in_array($paginaAtual, $acesso_telas_doador)) {
    // Se for doador e não tiver permissão para acessar a página, redireciona
    header("Location: login.php?erro=3");
    exit();
}
