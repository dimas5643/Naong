<?php
session_start(); // Inicia a sessão
session_destroy();

header("Location: index.php");
exit(); // Encerra o script para garantir que o redirecionamento ocorra
