<?php
require 'conexao.php';

$erro = "";
$sucesso = "";

if (isset($_POST['email'], $_POST['senha'], $_POST['tipo'])) {

    if (
        strlen($_POST['email']) == 0 &&
        strlen($_POST['senha']) == 0
    ) {

        $erro = "Preencha o E-mail e a senha";

    } else if (strlen($_POST['email']) == 0) {

        $erro = "Preencha o E-mail";

    } else if (strlen($_POST['senha']) == 0) {

        $erro = "Preencha a senha";

    } else if (strlen($_POST['tipo']) == 0) {

        $erro = "Preencha o tipo de usuário";

    } else {

        $email = trim($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $tipo = strtolower(trim($_POST['tipo']));

        if (
            $tipo != 'admin' &&
            $tipo != 'usuario'
        ) {

            $erro = "Digite apenas: admin ou usuario";

        } else {

            $stmt = $conexao->prepare(
                "SELECT id FROM usuarios_login WHERE email = ?"
            );

            $stmt->execute([$email]);

            if ($stmt->fetch()) {

                $erro = "Este E-mail já está cadastrado!";

            } else {

                $sql = "
                    INSERT INTO usuarios_login
                    (email, senha, tipo)
                    VALUES
                    (?, ?, ?)
                ";

                $stmt = $conexao->prepare($sql);

                $stmt->execute([
                    $email,
                    $senha,
                    $tipo
                ]);

                $sucesso = "Cadastro realizado com sucesso!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">

    <title>Cadastro</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="box">

    <h1>Cadastro</h1>

    <?php
        if (!empty($erro)) {
            echo "<p class='erro'>$erro</p>";
        }

        if (!empty($sucesso)) {
            echo "<p class='sucesso'>$sucesso</p>";
        }
    ?>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Digite seu E-mail"
            required
        >

        <input
            type="password"
            name="senha"
            placeholder="Digite sua senha"
            required
        >

        <input
            type="text"
            name="tipo"
            placeholder="Digite: admin ou usuario"
            class="tipo-input"
            required
        >

        <button type="submit">
            Cadastrar
        </button>

    </form>

    <p class="link">

        Já possui conta?

        <a href="index.php">
            Fazer login
        </a>

    </p>

</div>

</body>
</html>