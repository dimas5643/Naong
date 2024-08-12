<?php
session_start();

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "naong";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se o usuário está logado e obter o ID e o tipo de usuário da sessão
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
    $id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Determinar a tabela correta com base no tipo de usuário
    if ($user_role == 'ong') {
        $sql = "SELECT * FROM ongs WHERE id_ong = $id";
    } elseif ($user_role == 'doador') {
        $sql = "SELECT * FROM doadores WHERE id_doador = $id";
    } else {
        echo "Tipo de usuário inválido.";
        exit;
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Nenhum registro encontrado.";
        exit;
    }
} else {
    echo "Usuário não está logado.";
    exit;
}


include './banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $rua = $_POST['rua'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $pais = $_POST['pais'];
    $cep = $_POST['cep'];
    $numero_endereco = $_POST['numero_endereco'];
    $telefone = $_POST['telefone'];
    $ativo = $_POST['ativo'];

    // Proteção contra SQL Injection
    $ong = $conn->real_escape_string($id);
    $nome = $conn->real_escape_string($nome);
    $rua = $conn->real_escape_string($rua);
    $estado = $conn->real_escape_string($estado);
    $cidade = $conn->real_escape_string($cidade);
    $pais = $conn->real_escape_string($pais);
    $cep = $conn->real_escape_string($cep);
    $numero_endereco = $conn->real_escape_string($numero_endereco);
    $telefone = $conn->real_escape_string($telefone);
    $ativo = isset($_POST['ATIVO']) ? 'I' : 'A';

    $sql = "INSERT INTO `naong`.`pontos_coleta` (`ong`, `nome`, `rua`, `estado`, `cidade`, `pais`, `cep`, `numero_endereco`, `telefone`, `ativo`)  
            VALUES ('$ong', '$nome', '$rua',  '$estado', '$cidade', '$pais', '$cep', '$numero_endereco', '$telefone', '$ativo')";

    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
        //DIRECIONAR PARA A PAGINA PRINCIPAL 
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
