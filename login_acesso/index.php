<?php 
require 'conexao.php';

if (isset($_POST['email']) && isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        echo "Adicione seu email";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Adicione sua senha";
    } else {

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            echo "Login OK!";
        } else {
            echo "usuário ou senha, incorreto!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Faça o seu login:</h1>
    <form action="" method="POST">
        <p>
            <label>
                <input type="text" name="email" required><br>
            </label>
        </p>

        <hr>

        <p>
            <label>
                <input type="password" name="senha" required><br>
            </label>
        </p>

        <hr>

        <button type="submit">Acessar</button>
    </form>
</body>
</html>