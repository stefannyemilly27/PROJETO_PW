<?php
session_start();

if (!isset($_SESSION['email'])) {

    header("Location: index.php");
    exit;
}

if ($_SESSION['tipo'] != 'admin') {

    header("Location: home-comum.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">

    <h1>Home adm</h1>

    <p>Bem-vindo(a), <?php echo $_SESSION['email']; ?></p>

    <hr>

    <h2>Gerenciamento</h2>

    <ul>
        <li><a href="#">Gerenciar Posts</a></li>
        <li><a href="#">Gerenciar Categorias</a></li>
        <li><a href="#">Gerenciar Comentários</a></li>
    </ul>

    <hr>

    <a href="logout.php">Sair</a>

</div>

</body>
</html>