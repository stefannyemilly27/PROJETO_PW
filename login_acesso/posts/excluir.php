<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['email'])){
    header("Location: ../index.php");
    exit;

}

if ($_SESSION['tipo'] != 'admin') {
    header("Location: ../home-comum.php");
    exit;

}

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->execute([$id]);

$post = $stmt->fetch();

if (!$post) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = "DELETE FROM posts WHERE id = ?";

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
    <title>Excluir Post</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box">

    <h1>Excluir Post</h1>

    <p class="texto-excluir">
    Tem certeza que deseja excluir esse post?
    </p>

    <diV class="post-preview">

    <h2><?= $post['titulo'] ?></h2>

    <p><? $post['conteudo'] ?></p>

    </diV>

    <form method="POST">

    <button type="submit" class="btn-excluir">Excluir Post</button>

    </form>

    <br>

    <a href="index.php">

    <button type="submit" class="btn-cancelar">Cancelar</button>
    
    </a>

    </div>
</body>
</html>