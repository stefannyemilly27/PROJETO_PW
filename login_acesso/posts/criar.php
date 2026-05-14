<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../index.php");
    exit;
}

if (
    !isset($_SESSION['tipo']) ||
    $_SESSION['tipo'] != 'admin'
){
    header("location: ../home-comum.php");
    exit;
}

$erro = "";
$sucesso = "";
