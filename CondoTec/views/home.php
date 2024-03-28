<?php
session_start();
require_once('../models/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['nomeUsuario'])) {
    // Se não estiver logado, redireciona de volta para a página de login
    header("Location: ../models/login.php");
    exit();
}

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém o ID do usuário logadol
$id_usuario = $_SESSION['id'];

// Consulta para obter o número do apartamento do usuário logado
$query = $pdo->prepare("SELECT numero_apartamento FROM apartamentos WHERE id = :id");
$query->bindParam(':id', $id_usuario);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

// Verifica se a consulta retornou algum resultado
if ($resultado) {
    $numero_apartamento = $resultado['numero_apartamento'];
} else {
    $numero_apartamento = "Número de apartamento não registrado";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
    <link rel="stylesheet" href="../assets/estilo.css">
</head>
<body>
    <div>
        <h1>Bem vindo <?php echo $_SESSION['nomeUsuario']; ?> apartamento <?php echo $numero_apartamento; ?> </h1>
        <h2>Número de registro <?php echo $_SESSION['id']; ?></h2>
    </div>

    <div>
        <button onclick="window.location.href='suporte.php'">Suporte</button>
    </div>
    <div>
        <button onclick="window.location.href='visualizar_sup.php'">Visualizar Suporte</button>
    </div>

    <br/>
    
    <?php if ($numero_apartamento == "Número de apartamento não registrado"): ?>
    <!-- Mostrar o formulário de registro apenas se o usuário ainda não tiver registrado um apartamento -->
    <form action="../models/registrar_ap.php" method="post">
        <div>
            <input name="numero_apartamento" placeholder="Informe o número do apartamento">
        </div>
        <button type="submit">Registrar</button>
    </form>
    <?php endif; ?>
    
    <br/>
    <form action="../models/logoff.php" method="post">
        <button type="submit">Sair</button>
    </form>
</body>
</html>