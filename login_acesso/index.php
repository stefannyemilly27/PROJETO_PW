<?php 
session_start();
require 'conexao.php';

$erro = "";

if (isset($_POST['email']) && isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0 && strlen($_POST['senha']) == 0){
        $erro = "Adicione seu E-mail e senha";
    } else if (strlen($_POST['email']) == 0){
        $erro = "Adicione seu E-mail";
    } else if (strlen($_POST['senha']) == 0){
        $erro = "Adicione sua senha";
    }
     else {

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $conexao->prepare("SELECT * FROM usuarios_login WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            
            $_SESSION['user'] = $user['email'];
            header("Location: home-adm.php");
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

<h1>Faça o seu login:</h1>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

<form method="POST">
    <p>
        <input type="text" name="email" placeholder="Email" required>
    </p>

    <p>
        <input type="password" name="senha" placeholder="Senha" required>
    </p>

    <button type="submit">Acessar</button>

    <p>Não tem conta? <a href="cadastro.php">Cadastrar</a></p>

</form>

</body>
</html>