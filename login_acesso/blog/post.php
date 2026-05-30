<?php
session_start();
require "../conexao.php";


if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}

$sql = "
SELECT posts.*, categorias.nome AS categoria
FROM posts
INNER JOIN categorias
ON posts.categoria_id = categorias.id
ORDER BY posts.data_postagem DESC
";

$stmt = $conexao->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box">
    <h1>Posts do Blog</h1>
    <?php if(count($posts) > 0): ?>
        <?php foreach($posts as $post): ?>

            <div class="post-card">
                <h2 class="titulo-post"><?= $post['titulo'] ?></h2>
                <p class="categoria-post">Categoria: <?= $post['categoria'] ?></p>
                <p class="conteudo-post"><?= $post['conteudo'] ?></p>


                <div class="acoes">
                    <a href="comentarios/index.php?id=<?= $post['id'] ?>">Ver Comentários</a>
                </div>

            </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="sem-comentarios">Nenhum post foi criado ainda.</p>

        <?php endif; ?>
            <a href="../home-comum.php" class="bnt-voltar">Voltar</a>
    </div>
</body>
</html>
