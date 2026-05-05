<?php 
try {
    $conexao = new PDO("mysql:host=localhost;dbname=projeto_pw_blog;charset=utf8", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}