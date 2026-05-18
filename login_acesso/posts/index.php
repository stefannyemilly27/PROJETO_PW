<?php
session_start();
require '../conexao.php';

if (
    !isset($_SESSION['tipo']) ||
    $_SESSION['tipo'] != 'admin'
) {
    header("Location: ../home-comum.php");
    exit;
}

$sql = "
SELECT posts. *, categorias.nome AS categoria
FROM posts
INNER JOIN categorias
ON posts.categoria_id = categorias.id
";

$posts = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Posts</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="box">

<h1>Gerenciar Posts</h1>

<a href="criar.php">Criar Novo Post</a>

<hr>

<?php foreach($posts as $post): ?>

<div class="post">

    <h3><?= $post['titulo'] ?></h3>

    <p><?= $post['conteudo'] ?></p>

    <small>
        Categoria:
        <?= $post['categoria'] ?>
    </small>

    <div class="acoes">

        <a href="editar.php?id=<?= $post['id'] ?>">
            Editar
        </a>

        <a href="excluir.php?id=<?= $post['id'] ?>">
            Excluir
        </a>

    </div>

</div>

<?php endforeach; ?>

<br>

<a href="../home-adm.php">
    Voltar
</a>

</div>

</body>
</html>