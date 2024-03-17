<?php
// Inclua o arquivo que contém a definição da classe LoginController
require_once 'C:/xampp/htdocs/aulas/CondoTec/config/LoginController.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Cria uma instância do LoginController para lidar com o cadastro
    $loginController = new LoginController();
    // Aqui você pode manipular os dados do formulário se necessário
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
        <form action="" method="post">
            <div>
                <input name="nome" type="text" class="" placeholder="Nome" required>
            </div>
            <div>
                <input name="email" type="email" class="" placeholder="E-mail" required>
            </div>
            <div>
                <input name="senha" type="password" class="" placeholder="Senha" required>
            </div>
            <div>
                <input name="confirmar_senha" type="password" class="" placeholder="Confirmar senha" required>
            </div>
            <button type="submit">Cadastrar</button>
        </form>
        <button onclick="window.location.href='index.php'">Voltar</button>
    </div>
</body>
</html>
