<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}

if ($_SESSION['tipo'] != 'usuario'){

    header("Location: ../home-adm.php");
    exit;
}

if (!isset($_GET['id'])){

    header("Location: index.php");
    exit;
}

$post_id = $_GET['id'];

$sql = "
SELECT posts.*, categorias.nome AS categoria
FROM posts
INNER JOIN categorias
ON posts.categoria_id = categorias.id
WHERE posts.id = ?
";

$stmt = $conexao->prepare($sql);

$stmt->execute([$post_id]);

$post = $stmt->fetch();


if (!$post){

    header("Location: index.php");
    exit;
}

$erro = "";
$sucesso = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $comentario = trim($_POST['comentario']);
    $usuario_id = $_SESSION['id'];

    
if (empty($comentario)){

        $erro = "Digite um comentário!";

    } else {

    $sql = "
        INSERT INTO comentarios
        (comentario, usuario_id, post_id)
        VALUES (?, ?, ?)
        ";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            $comentario,
            $usuario_id,
            $post_id
        ]);

        $sucesso = "Comentário enviado com sucesso!";

    }

}

