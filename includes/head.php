<?php
// includes/head.php
// Este arquivo contém o cabeçalho HTML padrão para todas as páginas do projeto de cadastro de produtos.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px; /* Aumentado para acomodar a listagem */
            box-sizing: border-box;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }
        textarea {
            resize: vertical; /* Permite redimensionar verticalmente */
            min-height: 80px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .message.info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .text-center {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .text-center a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .text-center a:hover {
            text-decoration: underline;
        }

        /* --- Estilos para a Navegação --- */
        nav {
            background-color: #333;
            padding: 15px 0;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #555;
        }
        /* Ajuste para o conteúdo não ficar por baixo da nav */
        body > .container {
            margin-top: 90px; /* Altura da nav + um pouco de margem */
        }

        /* --- Estilos para a Tabela de Produtos --- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        table img {
            max-width: 80px;
            height: auto;
            border-radius: 4px;
        }
        .action-button {
            display: inline-block;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .delete-button {
            background-color: #dc3545; /* Vermelho */
            color: white;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .back-button {
            background-color: #6c757d; /* Cinza */
            color: white;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .confirmation-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            margin-top: 50px; /* Para centralizar melhor na tela */
        }
        .confirmation-box p {
            font-size: 1.1em;
            margin-bottom: 25px;
            color: #333;
        }
        .confirmation-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        /* --- Media Queries para Responsividade --- */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin-left: 10px;
                margin-right: 10px;
            }
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            nav ul li {
                margin: 10px 0;
            }
            body > .container {
                margin-top: 160px; /* Ajuste para a nav em coluna */
            }
            table th, table td {
                padding: 8px;
                font-size: 14px;
            }
            .action-button {
                padding: 6px 10px;
                font-size: 12px;
            }
            .confirmation-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
        @media (max-width: 480px) {
            table {
                font-size: 12px;
            }
            table th, table td {
                padding: 6px;
            }
            table img {
                max-width: 60px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="register_product.php">Cadastrar Produto</a></li>
            <li><a href="list_products.php">Ver Produtos</a></li>
        </ul>
    </nav>
