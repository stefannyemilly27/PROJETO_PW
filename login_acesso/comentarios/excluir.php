<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}


if (!isset($_GET['id'])){

    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$sql = "
SELECT comentarios.*, posts.titulo
FROM comentarios
INNER JOIN posts
ON comentarios.posts_id = posts.id
WHERE comentarios.id = ?
";

$stmt = $conexao->prepare($sql);
$stmt->execute([$id]);

$comentario = $stmt->fetch();

if (!$comentario){

    header("Location: index.php");
    exit;
}

if ($comentario['usuario_id'] != $_SESSION['id']){

    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $sql = "
    DELETE FROM comentarios
    WHERE id = ?
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Comentário</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
   <div class="box-comentario">
    <h1 class="titulo-pagina">Excluir Comentário</h1>

    <p class="texto-excluir">Tem certeza que deseja excluir esse comentário?</p>

    <div class="post-preview">
        <h2 class="titulo-post"><?= $comentario['titulo'] ?></h2>

        <p class="conteudo-post"><?= $comentario['comentario'] ?></p>

    </div>

    <form method="POST">

        <button type="submit" class="btn-excluir">Excluir Comentário</button>

    </form>

    <a href="index.php" class="btn-voltar">Cancelar</a>

   </div> 
</body>
</html>