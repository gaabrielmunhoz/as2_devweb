CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome_usuario VARCHAR(100) NOT NULL,
    login_usuario VARCHAR(100) UNIQUE NOT NULL,
    senha_usuario CHAR(60) NOT NULL
);

CREATE TABLE listas (
    id_lista INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_usuario INT NOT NULL,
    nome_lista VARCHAR(100) NOT NULL,
    descricao_lista TEXT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE tarefa (
    id_tarefa INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_lista INT,
    titulo_tarefa VARCHAR(100) NOT NULL,
    descricao_tarefa text,
    status_tarefa ENUM('pendente','concluida') DEFAULT 'pendente',
    tarefa_arquivada TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_lista) REFERENCES listas(id_lista)
);