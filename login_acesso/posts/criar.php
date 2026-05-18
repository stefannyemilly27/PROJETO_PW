<?php
session_start();
require '../conexao.php';

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


$sql = "SELECT * FROM categorias";
$stmt = $conexao->query($sql);
$categorias = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$titulo = $_POST['titulo'];
$conteudo = $_POST['conteudo'];
$categoria_id = $_POST['categoria_id'];
$usuario_id = $_SESSION['id'];

if (empty($titulo) || empty($conteudo)) {

    $erro = "Preencha todos os campos!";

} else {

        $sql = "
        INSERT INTO posts
        (titulo, conteudo, usuario_id, categoria_id) 
        VALUES (?, ?, ?, ?)
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            $titulo,
            $conteudo,
            $usuario_id,
            $categoria_id
        ]);

        $sucesso = "Post criado com sucesso!!";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Posts</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="box">
    <h1>Criar Posts</h1>

        <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>

        <?php if (!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>

        <form method="POST">

        <input type="text" name="titulo" placeholder="Título do post" required>

        <textarea name="conteudo" placeholder="Conteúdo" required></textarea>

        <select name="categoria_id" required>

        <option value="">Escolha uma categoria</option>

        <?php foreach($categorias as $categoria): ?>

        <option value="<?= $categoria['id'] ?>">

        <?= $categoria['nome'] ?>

        </option>

        <?php endforeach; ?>

        </select>

        <button type="submit">Criar Post</button>

        </form>

    </div>
</body>
</html>