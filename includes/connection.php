<?php
// Database connection file
$host = 'localhost';
$dbname = 'cadastro_produtos_db';
$dbuser = 'root';
$dbpassword = 'root';


// mysql:host=$host;dbname=$dbname
$pdo = new PDO( "mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
// Seta o modo de erro do PDO para exceção
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Seta o modo de busca padrão para FETCH_ASSOC (array associativo)
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);