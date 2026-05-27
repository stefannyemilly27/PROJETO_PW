<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}

if ($_SESSION['tipo'] != 'admin'){

    header("Location: ../home-comum.php");
    exit;
}

if (!isset($_GET['id'])){

    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM categorias WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->execute([$id]);

$categoria = $stmt->fetch();

if (!$categoria){

    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $sql = "SELECT COUNT(*) FROM posts WHERE categoria_id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->fetchColumn() > 0) {
        die("Não é possível excluir: existem posts nessa categoria.");
    }

    $sql = "DELETE FROM categorias WHERE id = ?";

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
<title>Excluir Categoria</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

    <div class="box">
        <h1>Excluir Categoria</h1>
        <p class="texto-excluir">Tem certeza que deseja excluir essa categoria?</p>

    <div class="categoria-preview">

        <h2><?= $categoria['nome'] ?></h2>

    </div>

    
    <form method="POST">
        <button type="submit" class="btn-excluir">Excluir Categoria</button>
    </form>

    <br>

    <a href="index.php" class="btn-cancelar">Cancelar</a>

    </div>

</body>
</html>