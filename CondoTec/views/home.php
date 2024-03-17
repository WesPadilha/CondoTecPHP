<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['nomeUsuario'])) 
{
    // Se não estiver logado, redireciona de volta para a página de login
    header("Location: ../models/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
</head>
<body>
    <div>
        <h1>Bem vindo <?php echo $_SESSION['nomeUsuario']; ?> </h1>
    </div>

    <div>
        <button onclick="window.location.href='suporte.php'">Suporte</button>
    </div>

    <br/>
    
    <form action="../models/registrar_ap.php" method="post">
        <div>
            <input name="numero_apartamento" placeholder="Informe o número do apartamento">
        </div>
        <button type="submit">Registrar</button>
    </form>
    <br/>
    <form action="../models/logoff.php" method="post">
        <button type="submit">Sair</button>
    </form>
</body>
</html>
