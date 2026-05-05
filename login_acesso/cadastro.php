<?php
require 'conexao.php';

$erro = "";
$sucesso = "";

if (isset($_POST['email'], $_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        $erro = "Preencha o email";
    } else if (strlen($_POST['senha']) == 0) {
        $erro = "Preencha a senha";
    } else {

        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        // Verifica se já existe
        $stmt = $conexao->prepare("SELECT id FROM usuarios_login WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $erro = "Email já cadastrado!";
        } else {

            $sql = "INSERT INTO usuarios_login (email, senha) VALUES (?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$email, $senha]);

            $sucesso = "Cadastro realizado com sucesso!";
        }
    }
}
?>

<body>

<div class="box">

    <h1>Cadastro</h1>

    <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <?php if (!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit">Cadastrar</button>

    </form>

    <p class="link">
        Já tem conta? <a href="index.php">Fazer login</a>
    </p>

</div>

</body>