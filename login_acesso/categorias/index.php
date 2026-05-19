<?php
session_start();

require "../conexao.php";

if (!isset($_SESSION['email'])){
    header("Location: ../index.php");
    exit;

}

if ($_SESSION['tipo'] != 'admin'){
    header("Location: ../home-comum.php");
    exit;

}

$sql = "SELECT * FROM categorias";

$stmt = $conexao->query($sql);

$categorias = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box">

    <h1>Gerenciar Categorias</h1>

    <a href="criar.php">
        
    <button>Criar Categoria</button>

    </a>

    <hr>

    <?php foreach($categorias as $categoria): ?>

        <div class="categorias">

        <h2><?= $categoria['nome'] ?></h2>

        <a href="editar.php?id=<?= $categoria['id'] ?>">

            <button>Editar</button>

        </a>

        <a href="excluir.php?id=<?= $categoria['id'] ?>">

            <button>Excluir</button>

        </a>
        
        </div>

        <hr>

    <?php endforeach; ?>

    </div>
</body>
</html>