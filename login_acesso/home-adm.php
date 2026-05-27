<?php
session_start();

if (!isset($_SESSION['email'])) {

    header("Location: index.php");
    exit;
}

if (
    !isset($_SESSION['tipo']) ||
    $_SESSION['tipo'] !== 'admin'
) {

    header("Location: blog/home-comum.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Home adm</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">

    <h1>Painel do Administrador</h1>

    <p>
        Bem-vindo(a),
        <?php echo $_SESSION['email']; ?>
    </p>

    <hr>

    <h2>Gerenciamento do Blog</h2>

    <ul class="menu-admin">
        <li><a href="posts/index.php">Gerenciar Posts</a></li>
        <li><a href="categorias/index.php">Gerenciar Categorias</a></li>
        <li><a href="comentários/index.php">Gerenciar Comentários</a></li>
    </ul>

    <hr>

    <a href="logout.php">Sair</a>

</div>

</body>
</html>