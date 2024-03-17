<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'C:/xampp/htdocs/aulas/CondoTec/models/conexao.php';
    $conexao = new Conexao();
    $pdo = $conexao->conectar();

    $numero_apartamento = $_POST['numero_apartamento'];
    $id_usuario = $_SESSION['idUsuario']; // Supondo que você tenha armazenado o ID do usuário na sessão após o login

    $sql = "UPDATE usuarios SET numero_apartamento = :numero_apartamento WHERE id = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':numero_apartamento', $numero_apartamento);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();

    // Redireciona para a página home após a atualização
    header("Location: ../views/home.php");
    exit();
}
?>
