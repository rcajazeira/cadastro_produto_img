<?php
// list_products.php
// Página para exibir a lista de produtos cadastrados com imagem e opção de exclusão.

// Inclui o arquivo de conexão com o banco de dados.
require_once 'includes/connection.php';
// Inclui o cabeçalho HTML e CSS (que agora contém a navegação).
require_once 'includes/head.php';

$message = ''; // Variável para armazenar mensagens de feedback

// --- Mensagens de Feedback (após exclusão ou cancelamento) ---
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'deleted') {
        $message = '<div class="message success">Produto excluído com sucesso!</div>';
    } elseif ($_GET['status'] === 'cancelled') {
        $message = '<div class="message info">Exclusão cancelada.</div>';
    } elseif ($_GET['status'] === 'error') {
        $message = '<div class="message error">Erro ao excluir o produto.</div>';
    } elseif ($_GET['status'] === 'invalid_id') {
        $message = '<div class="message error">ID do produto inválido ou não encontrado.</div>';
    }
}

// --- Busca todos os Produtos ---
$produtos = []; // Array para armazenar os produtos
try {
    // Consulta todos os produtos na tabela 'produto'
    $stmt = $pdo->query("SELECT id, nome, descricao, preco, estoque, imagem_path FROM produto ORDER BY id ASC");
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = '<div class="message error">Erro ao buscar produtos: ' . $e->getMessage() . '</div>';
}
?>

<div class="container">
    <h2>Produtos Cadastrados</h2>

    <?php echo $message; // Exibe a mensagem de feedback ?>

    <?php if (!empty($produtos)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produto['id']); ?></td>
                        <td>
                            <?php if (!empty($produto['imagem_path']) && file_exists($produto['imagem_path'])): ?>
                                <img src="<?php echo htmlspecialchars($produto['imagem_path']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                            <?php else: ?>
                                [Sem Imagem]
                            <?php endif; ?>
                        </td>
                        <td><?php echo $produto['nome']; ?></td> <!-- ALTERADO AQUI: Removido htmlspecialchars() -->
                        <td><?php echo $produto['descricao']; ?></td>
                        <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($produto['estoque']); ?></td>
                        <td>
                            <!-- Botão Excluir que redireciona para a página de confirmação -->
                            <a href="confirm_delete_product.php?id=<?php echo htmlspecialchars($produto['id']); ?>"
                               class="action-button delete-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="message info">Nenhum produto cadastrado. <a href="register_product.php">Cadastre um agora!</a></div>
    <?php endif; ?>
</div>

<?php
// Inclui o rodapé HTML.
require_once 'includes/bottom.php';
?>
