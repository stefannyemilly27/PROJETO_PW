<?php
session_start();

if (!isset($_SESSION['email'])) {

    header("Location: index.php");
    exit;
}

if ($_SESSION['tipo'] == 'admin') {

    header("Location: home-adm.php");
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

    <h1>Bem-vindo ao Blog</h1>

    <p>Olá, <?php echo $_SESSION['email']; ?></p>

    <hr>

    <h2>Área do Usuário</h2>

    <ul>
        <li><a href="#">Ver Posts</a></li>
        <li><a href="#">Comentar</a></li>
        <li><a href="#">Meu Perfil</a></li>
    </ul>

    <hr>

    <a href="logout.php">Sair</a>

</div>

</body>
</html>