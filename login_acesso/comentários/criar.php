<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}

if (isset($_SESSION['tipo']) == 'admin'){

    header("Location: ../home-adm.php");
    exit;
}

if (!isset($_GET['id'])){

    header("Location: index.php");
    exit;
}

$post_id = $_GET['id'];

$sql = "
SELECT posts.*, categorias.nome AS categoria
FROM posts
INNER JOIN categorias
ON posts.categoria_id = categorias.id
WHERE posts.id = ?
";

$stmt = $conexao->prepare($sql);

$stmt->execute([$post_id]);

$post = $stmt->fetch();


if (!$post){

    header("Location: index.php");
    exit;
}

$erro = "";
$sucesso = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $comentario = trim($_POST['comentario'] ?? '');
    $usuario_id = $_SESSION['id'];

    
if (empty($comentario)){

        $erro = "Digite um comentário!";

    } else {

    $sql = "
        INSERT INTO comentarios
        (comentario, usuario_id, post_id)
        VALUES (?, ?, ?)
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            $comentario,
            $usuario_id,
            $post_id
        ]);

        $sucesso = "Comentário enviado com sucesso!";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Comentários</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box-comentario">
         <h1 class="titulo-pagina">Comentar no Post</h1>

         <?php if (!empty($erro)): ?>
            <p class="erro"><?= $erro ?></p>

        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <p class="sucesso"><?= $sucesso ?></p>

            <?php endif; ?>

        <div class="post-preview">
            <h2 class="titulo-post"><?= $post['titulo'] ?></h2>
            <p class="categoria-post">Categoria: <?= $post['categoria'] ?></p>
            <p class="conteudo-post"><?= $post['conteudo'] ?></p>
        </div>

        <form method="POST" class="form-comentario">
            <textarea name="comentario" placeholder="Digite seu comentário..." required></textarea>
            <button type="submit" class="btn-comentar">Comentar</button>
        </form>

        <a href="index.php" class="btn-voltar">Voltar</a>

    </div>
</body>
</html>