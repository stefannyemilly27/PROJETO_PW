<?php 
require 'conexao.php';
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