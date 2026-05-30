<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){
    
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['tipo'] == 'admin'){

    header("Location: ../home-adm.php");
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
ON comentarios.post_id = posts.id
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

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $novoComentario = trim($_POST['comentario'] ?? '');

    if (empty($novoComentario)){
        $erro = "Digite um comentário!";
    } else {
        $sql = "
        UPDATE comentarios
        SET comentario = ?
        WHERE id = ?
        ";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $novoComentario,
            $id
        ]);

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentário</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box-comentario">
        <h1 class="titulo-pagina">Editar Comentário</h1>
        <?php if (!empty($erro)): ?>
            <p class="erro"><?= $erro ?></p>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <p class="sucesso"><?= $sucesso ?></p>
        <?php endif; ?>

        <div class="post-preview">
            <h2 class="titulo-post"><?= $comentario['titulo'] ?></h2>
        </div>

        <form method="POST" class="form-comentario">
            <textarea name="comentario" placeholder="Digite seu comentário..." required><?= $comentario['comentario'] ?></textarea>
            <button type="submit" class="btn-comentar">Salvar</button>
        </form>

        <a href="index.php" class="btn-voltar">Voltar</a>

    </div>
</body>
</html>