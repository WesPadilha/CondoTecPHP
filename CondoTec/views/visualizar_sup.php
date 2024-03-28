<?php
session_start(); // Iniciar a sessão

require_once('../models/conexao.php');
require_once('../models/suporte_crud.php');
require_once('../models/suporte.model.php');

if (!isset($_SESSION['nomeUsuario'])) {
    // Se não estiver logado, redireciona de volta para a página de login
    header("Location: ../models/login.php");
    exit();
}

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém o ID do usuário logado
$id_usuario = $_SESSION['id'];

// Instancie a classe Suporte_crud
$superteService = new Suporte_crud($conexao, new Suporte());

// Recuperar as solicitações de suporte apenas se o usuário estiver logado
if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id']; // Supondo que o ID do usuário esteja armazenado na sessão
    $suportes = $superteService->recuperarPorUsuario($idUsuario);
}

if (isset($_GET['acao']) && $_GET['acao'] === 'atualizar') {
    if (isset($_GET['protocolo']) && isset($_GET['informacao']) && isset($_GET['descricao'])) {
        $protocolo = $_GET['protocolo'];
        $informacao = $_GET['informacao'];
        $descricao = $_GET['descricao'];
        $superteService->atualizar($protocolo, $informacao, $descricao);
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluir') {
    if (isset($_GET['protocolo'])) {
        $protocolo = $_GET['protocolo'];
        $superteService->remover($protocolo);
    }
}


// Obtém o ID do usuário logado
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

// Instancie a classe Suporte_crud
$superteService = new Suporte_crud($conexao, new Suporte());

// Agora você pode chamar seus métodos
$idUsuario = $_SESSION['id']; // Supondo que o ID do usuário esteja armazenado na sessão
$suportes = [];

// Recuperar as solicitações de suporte apenas se o usuário estiver logado
if (isset($_SESSION['id'])) {
    $suportes = $superteService->recuperarPorUsuario($idUsuario);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
    <link rel="stylesheet" href="../assets/estilo.css">
    <script>
        function editar(protocolo, informacao, descricao) {
            // Preencha os campos de edição com os valores atuais
            document.getElementById('edit_informacao').value = informacao;
            document.getElementById('edit_descricao').value = descricao;
            // Exiba o formulário de edição
            document.getElementById('editar_form').style.display = 'block';
            // Configure o protocolo do suporte a ser atualizado
            document.getElementById('suporte_protocolo').value = protocolo;
        }

        function remover(protocolo) {
            // Envie uma solicitação de exclusão para o servidor
            if (confirm('Tem certeza que deseja excluir este item?')) {
                window.location.href = 'visualizar_sup.php?acao=excluir&protocolo=' + protocolo;
            }
        }

        function atualizar() {
            // Obtenha os novos valores dos campos de edição
            var informacao = document.getElementById('edit_informacao').value;
            var descricao = document.getElementById('edit_descricao').value;
            // Obtenha o protocolo do suporte a ser atualizado
            var protocolo = document.getElementById('suporte_protocolo').value;
            // Envie uma solicitação de atualização para o servidor
            window.location.href = 'visualizar_sup.php?acao=atualizar&protocolo=' + protocolo + '&informacao=' + informacao + '&descricao=' + descricao;
        }
    </script>

</head>
<body>
    <div>
        <h1>Bem vindo <?php echo $_SESSION['nomeUsuario']; ?> apartamento <?php echo $numero_apartamento; ?> </h1>
        <h2>Número de registro <?php echo $_SESSION['id']; ?></h2>
    </div>

    <div>
        <h3>Suas Solicitações:</h3>
        <ul>
            <?php foreach($suportes as $suporte) { ?>
                <li>
                    Protocolo: <?php echo $suporte->protocolo; ?><br>
                    Categoria: <?php echo $suporte->categoria; ?><br>
                    Informação: <?php echo $suporte->informacao; ?><br>
                    Descrição: <?php echo $suporte->descricao; ?><br>
                    Caráter: <?php echo $suporte->carater; ?><br>
                    <!-- Botões para editar e excluir -->
                    <button onclick="editar(<?php echo $suporte->protocolo; ?>, '<?php echo $suporte->informacao; ?>', '<?php echo $suporte->descricao; ?>')">Editar</button>
                    <button onclick="remover(<?php echo $suporte->protocolo; ?>)">Excluir</button>
                </li>
            <?php } ?>
        </ul>
    </div>


    <!-- Formulário de edição (invisível por padrão) -->
    <div id="editar_form" style="display: none;">
        <form>
            Informação: <input type="text" name="edit_informacao" id="edit_informacao"><br>
            Descrição: <textarea type="text" name="edit_descricao" id="edit_descricao"></textarea><br>
            <!-- Input oculto para armazenar o ID do suporte a ser atualizado -->
            <input type="hidden" id="suporte_protocolo">
            <button type="button" onclick="atualizar()">Salvar</button>
        </form>
    </div>

    <button onclick="window.location.href='home.php'">Home</button>
</body>
</html>
