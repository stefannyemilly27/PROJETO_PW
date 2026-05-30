<?php
session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}

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
    <?php if (!isset($_GET['id'])): ?>

        <h1>Categorias</h1>

        <?php 

        $sql = "SELECT * FROM categorias";

        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $categorias = $stmt->fetchAll();
        ?>

        <?php foreach($categorias as $categoria): ?>

            <div class="categorias">
                <h2><?= $categoria['nome'] ?></h2>

                <div class="acoes">
                <a href="categoria.php?id=<?= $categoria['id'] ?>" class="btn-editar">Ver Posts</a>
                </div>
            </div>

    <?php endforeach; ?>
    <a href="../home-comum.php" class="btn-voltar">Voltar</a>

<?php else: ?>

<?php

$id = $_GET['id'] ?? null;

$posts = [];

if ($id) {

    $sql = "
    SELECT posts.*, categorias.nome AS categoria
    FROM posts
    INNER JOIN categorias
    ON posts.categoria_id = categorias.id
    WHERE posts.categoria_id = ?
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);
    $posts = $stmt->fetchAll();
}

?>

<h1>Posts da Categoria</h1>

<?php if(count($posts) > 0): ?>

    <?php foreach($posts as $post): ?>

        <div class="post-card">

            <h2 class="titulo-post"><?= $post['titulo'] ?></h2>
            <p class="categoria-post"> Categoria: <?= $post['categoria'] ?></p>
            <p class="conteudo-post"><?= $post['conteudo'] ?></p>

            <div class="acoes">
                <a href="../comentarios/index.php?id=<?= $post['id'] ?>"class="btn-editar">Ver Comentários</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="sem-comentarios">Nenhum post encontrado.</p>

<?php endif; ?>
    <a href="../home-comum.php" class="btn-voltar">Voltar</a>
<?php endif; ?>
    </div>
</body>
</html>