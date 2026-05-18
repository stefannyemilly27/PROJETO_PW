<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])) {

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

$sql = "SELECT * FROM posts WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->execute([$id]);

$post = $stmt->fetch();

if (!$post) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    if (empty($titulo) || empty($conteudo)) {

        $erro = "Preencha os campos!";

    } else {

    $sql = "
        UPDATE posts
        SET titulo = ?, conteudo = ?
        WHERE id = ?
    ";


    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        $titulo,
        $conteudo,
        $id
    ]);

    $sucesso = "Post atualizado com sucesso!!";

    $post['titulo'] = $titulo;
    $post['conteudo'] = $conteudo;


    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta charset="UTF-8">

<title>Editar Posts</title>

<link rel="stylesheet" href="../style.css">

</head>
<body>

<div class="box">

<h1>Editar Post</h1>



<?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>

<?php if (!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>



<form method="POST">



<input
type="text"
name="titulo"
value="<?= $post['titulo'] ?>"
required
>



<textarea
name="conteudo"
required
><?= $post['conteudo'] ?></textarea>



<button type="submit">

Salvar Alterações

</button>

</form>

</div>

</body>
</html>