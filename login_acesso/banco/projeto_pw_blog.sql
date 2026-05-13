CREATE DATABASE IF NOT EXISTS projeto_pw_blog;

USE projeto_pw_blog;



CREATE TABLE usuarios_login (

    id INT AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(255) NOT NULL UNIQUE,

    senha VARCHAR(255) NOT NULL,

    tipo VARCHAR(20) NOT NULL DEFAULT 'usuário'

);



CREATE TABLE categorias (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL UNIQUE

);



CREATE TABLE posts (

    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(255) NOT NULL,

    conteudo TEXT NOT NULL,

    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    usuario_id INT NOT NULL,

    categoria_id INT NOT NULL,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios_login(id)
        ON DELETE CASCADE,

    FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON DELETE CASCADE

);



CREATE TABLE comentarios (

    id INT AUTO_INCREMENT PRIMARY KEY,

    comentario TEXT NOT NULL,

    data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    usuario_id INT NOT NULL,

    post_id INT NOT NULL,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios_login(id)
        ON DELETE CASCADE,

    FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE

);