<?php

session_start();

require "../conexao.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['tipo'] != 'admin'){
    header("Location: ../home-comum.php");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];

    if (empty($nome)){
        $erro = "Preencha o nome da categoria!";
    } else {
        $sql = "INSERT INTO categorias (nome)
        VALUES (?)
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([$nome]);

        $sucesso = "Categoria criada com sucesso!";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Categorias</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box">
    <h1>Criar Categoria</h1>
    
    <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <?php if (!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>

    <form method="POST">

    <input type="text" name="nome" placeholder="Nome da Categoria" required>

    <button type="submit">Criar Categoria</button>

    </form>

    </div>
</body>
</html>



