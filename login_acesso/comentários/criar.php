<?php

session_start();
require "../conexao.php";

if (!isset($_SESSION['email'])){

    header("Location: ../index.php");
    exit;
}

if ($_SESSION['tipo'] != 'admin'){

    header("Location: ../home-comum.php");
    exit;
}

$erro = "";
$sucesso = "";

$sql = "SELECT * FROM comentarios";

$stmt = $conexao->query($sql);
$comentarios = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
}