<?php
session_start();
require 'conexao.php';

$erro = "";

if (isset($_POST['email']) && isset($_POST['senha'])) {

    if (
        strlen($_POST['email']) == 0 &&
        strlen($_POST['senha']) == 0
    ) {

        $erro = "Adicione seu E-mail e senha";

    } else if (strlen($_POST['email']) == 0) {

        $erro = "Adicione seu E-mail";

    } else if (strlen($_POST['senha']) == 0) {

        $erro = "Adicione sua senha";

    } else {

        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);

        $stmt = $conexao->prepare(
            "SELECT * FROM usuarios_login WHERE email = ?"
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['tipo'] = $user['tipo'];

            if ($user['tipo'] == 'admin') {

                header("Location: home-adm.php");

            } else {

                header("Location: home-comum.php");
            }

            exit;

        } else {

            $erro = "E-mail ou senha incorretos!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">

    <h1>Login</h1>

    <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit">Entrar</button>

    </form>

    <p>
        Não tem conta?
        <a href="cadastro.php">Cadastrar</a>
    </p>

</div>

</body>
</html>