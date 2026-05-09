<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

echo "Você está logado! <br>";
echo "<a href='logout.php'>Sair</a>";