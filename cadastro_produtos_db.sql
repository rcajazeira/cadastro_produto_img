CREATE DATABASE cadastro_produtos_db;
USE cadastro_produtos_db;
CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    imagem_path VARCHAR(255) NULL
);

select * from produto;