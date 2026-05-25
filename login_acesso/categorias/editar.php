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

$erro = "";
$sucesso = "";

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

    $nome = $_POST['nome'];

    if (empty($nome)){

        $erro = "Preencha os campos!";
    } else {

        $sql = "UPDATE categorias
        SET nome = ? WHERE id = ?";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            $nome,
            $id
        ]);

        $sucesso = "Categoria atualizada com sucesso!!";

        $categoria['nome'] = $nome;
    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categorias</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box">
        <h1>Editar Categoria</h1>

        <?php if(!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>
        <?php if(!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>

        <form method="POST">

        <input type="text" name="nome" value="<?= $categoria['nome'] ?>" placeholder="Nome da Categoria" required>

        <button type="submit">Editar Categoria</button>

        </form>

    </div>
</body>
</html>
