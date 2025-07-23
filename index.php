<?php
// index.php
// Página inicial do projeto de cadastro de produtos.

// Inclui o cabeçalho HTML e CSS.
require_once 'includes/head.php';
?>

<div class="container">
    <h2>Bem-vindo ao Sistema de Cadastro de Produtos</h2>
    <p class="text-center">Aqui você pode cadastrar novos produtos, incluindo a imagem.</p>
    <p class="text-center">
        <a href="register_product.php" class="action-button" 
           style="background-color: #28a745; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
           Cadastrar Novo Produto
        </a>
    </p>
</div>

<?php
// Inclui o rodapé HTML.
require_once 'includes/bottom.php';
?>
