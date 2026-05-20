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


