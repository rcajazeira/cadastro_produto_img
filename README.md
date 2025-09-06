# 📦 Cadastro de Produtos com Imagem

Sistema simples desenvolvido em **PHP com PDO** para gerenciar produtos, incluindo upload e exclusão de imagens.

## 🚀 Funcionalidades
- ➕ **Cadastrar produto** com nome, descrição, preço e imagem.  
- 🖼️ **Upload de imagem** armazenando o arquivo no servidor e a referência no banco.  
- 📋 **Listagem de produtos** exibindo dados e imagem associada.  
- ❌ **Excluir produto**, removendo também a imagem vinculada.  

## 🛠️ Tecnologias Utilizadas
- **PHP 8+**
- **PDO (PHP Data Objects)** para conexão segura com MySQL.
- **HTML5 + CSS3** para interface.
- **MySQL** para armazenamento dos dados.

## 📂 Estrutura do Projeto
cadastro_produto_img/
│── conexao.php # Conexão com o banco (PDO)
│── cadastrar.php # Cadastro de produtos
│── listar.php # Listagem de produtos
│── excluir.php # Exclusão de produtos
│── upload/ # Pasta onde ficam as imagens salvas
│── index.php # Página inicial


## ⚙️ Como Usar
1. Clone este repositório:  
   ```bash
   git clone https://github.com/rcajazeira/cadastro_produto_img.git

Crie um banco de dados MySQL e configure o arquivo conexao.php.

Execute os scripts PHP em um servidor local (ex.: XAMPP, WAMP, Laragon).

Acesse pelo navegador:
http://localhost/cadastro_produto_img

📝 Observações

Ao excluir um produto, a imagem associada também é removida do diretório upload/.

O sistema é um exemplo básico, ideal para aprendizado de CRUD com PHP + PDO.

👨‍💻 Desenvolvido por Rafael Cajazeira

---


