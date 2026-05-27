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

    <a href="criar.php" class="btn-link">Criar Categoria</a>

    <hr>

    <?php if (count($categorias) > 0): ?>

    <?php foreach($categorias as $categoria): ?>

        <div class="categorias">

        <h2><?= $categoria['nome'] ?></h2>

        <div class="acoes">

        <a href="editar.php?id=<?= $categoria['id'] ?>" class="btn-editar">Editar</a>

        <a href="excluir.php?id=<?= $categoria['id'] ?>" class="btn-excluir-link">Excluir</a>

        </div>

    </div>

        <hr>

    <?php endforeach; ?>

    <?php else: ?>

        <p class="sem-categorias">Nenhuma categoria cadastrada</p>

    <?php endif; ?>

        <a href="../home-adm.php" class="btn-voltar">Voltar</a>

    </div>
</body>
</html>