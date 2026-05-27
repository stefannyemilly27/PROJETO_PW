<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['email'])) {

    header("Location: ../index.php");
    exit;
}

if (
    !isset($_SESSION['tipo']) ||
    $_SESSION['tipo'] != 'usuário'
) {

    header("Location: ../home-adm.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Home Usuário</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="box">

    <h1>Blog</h1>

    <p>
        Olá,
        <?php echo $_SESSION['email']; ?>
    </p>

    <hr>

    <h2>Área do Usuário</h2>

    <ul>
        <li><a href="post.php">Ver Posts</a></li>
        <li><a href="index.php">Comentar nos Posts</a></li>
        <li><a href="categoria.php">Ver posts por categorias</a></li>
    </ul>

    <hr>

    <a href="../logout.php">Sair</a>

</div>

</body>
</html>