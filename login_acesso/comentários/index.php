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

$stmt = $conexao->query($sql);
$posts = $stmt->fetchAll();

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $comentario = $_POST['comentario'];
    $post_id = $_POST['post_id'];
    $usuario_id = $_SESSION['id'];

    if (empty($comentario)){

    $erro = "DIgite um comentário!";
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

    $sucesso = "Comentário enviado!";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Comentários</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container-posts">
        <h1 class="titulo-pagina">Posts do Blog</h1>

        <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>
        <?php if (!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>

        <?php foreach($posts as $post): ?>
        
    <div class="post-card">
        <h2 class="titulo-post"><?= $post['titulo'] ?></h2>

        <p class="categoria-post">Categoria: <?= $post['categoria'] ?></p>

        <p class="conteudo-post"><?= $post['conteudo'] ?></p>

        <hr>

        <h3 class="titulo-comentarios">Comentários</h3>

        <?php

        $sqlComentarios = "
        SELECT comentarios.*, usuarios_login.email
        FROM comentarios
        INNER JOIN usuarios_login
        ON comentarios.usuario_id = usuarios_login.id
        WHERE comentarios.post_id = ?
        ORDER BY comentarios.data_comentario DESC
        ";

        $stmtComentarios = $conexao->prepare($sqlComentarios);

        $stmtComentarios->execute([$post['id']]);

        $comentarios = $stmtComentarios->fetchAll();

        ?>

        <?php if(count($comentarios) > 0): ?>

        <?php foreach($comentarios as $comentario): ?>

    <div class="comentario-box">

        <p class="autor-comentario"><?= $comentario['email'] ?></p>

        <p class="texto-comentario"> <?= $comentario['comentario'] ?></p>

        <?php if($comentario['usuario_id'] == $_SESSION['id']): ?>
                    
    <div class="acoes-comentario">
        <a href="../comentarios/editar.php?id=<?= $comentario['id'] ?>">Editar</a>
        <a href="../comentarios/excluir.php?id=<?= $comentario['id'] ?>">Excluir</a>

    </div>
    <?php endif; ?>

    </div>

    <?php endforeach; ?>

    <?php else: ?>
    <p class="sem-comentarios">Não existe nenhum comentário ainda</p>
    

    <?php endif; ?>

    <?php if ($_SESSION['tipo'] == 'usuario'): ?>

    <form method="POST" class="form-comentario">

        <textarea name="comentario" placeholder="Digite seu comentário..." required></textarea>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="submit">Comentar</button>
    </form>

    <?php endif; ?>

    </div>
    
    <?php endforeach; ?>

    <a href="../blog/home-comum.php" class="btn-voltar">Voltar</a>

        
    </div>
</body>
</html>