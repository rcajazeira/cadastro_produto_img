<?php
// confirm_delete_product.php
// Página para confirmar a exclusão de um produto e executar a exclusão.

// Inclui o arquivo de conexão com o banco de dados.
require_once 'includes/connection.php';
// Inclui o cabeçalho HTML e CSS.
require_once 'includes/head.php';

$message = ''; // Variável para armazenar mensagens de feedback
$produto = null; // Variável para armazenar os dados do produto a ser excluído

// --- 1. Processar a solicitação de exclusão (se o formulário de confirmação foi enviado) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $idToDelete = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $imagePathToDelete = filter_input(INPUT_POST, 'image_path', FILTER_SANITIZE_URL); // Caminho da imagem para exclusão

    if ($idToDelete) {
        try {
            // Inicia uma transação para garantir que a exclusão do BD e do arquivo sejam atômicas
            $pdo->beginTransaction();

            // Prepara a query SQL para deletar o produto do banco de dados
            $stmt = $pdo->prepare("DELETE FROM produto WHERE id = :id");
            $stmt->bindParam(':id', $idToDelete, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Se a exclusão do BD foi bem-sucedida, tenta deletar o arquivo de imagem
                if (!empty($imagePathToDelete) && file_exists($imagePathToDelete)) {
                    if (unlink($imagePathToDelete)) {
                        // Imagem deletada com sucesso
                    } else {
                        // Erro ao deletar a imagem (pode ser logado, mas não impede o commit do BD)
                        error_log("Erro ao deletar arquivo de imagem: " . $imagePathToDelete);
                    }
                }

                $pdo->commit(); // Confirma a transação
                // Redireciona para list_products.php com status de sucesso
                header("Location: list_products.php?status=deleted");
                exit();
            } else {
                $pdo->rollBack(); // Reverte a transação
                // Redireciona com status de erro
                header("Location: list_products.php?status=error");
                exit();
            }
        } catch (PDOException $e) {
            $pdo->rollBack(); // Reverte a transação em caso de erro no BD
            // Redireciona com status de erro de banco de dados
            header("Location: list_products.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        // ID inválido na confirmação POST
        header("Location: list_products.php?status=invalid_id");
        exit();
    }
}

// --- 2. Carregar os dados do produto para exibição (quando a página é acessada via GET) ---
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    // Se nenhum ID válido for fornecido na URL, redireciona para a listagem
    header("Location: list_products.php?status=invalid_id");
    exit();
}

try {
    // Busca os detalhes do produto pelo ID
    $stmt = $pdo->prepare("SELECT id, nome, descricao, preco, estoque, imagem_path FROM produto WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $produto = $stmt->fetch();

    if (!$produto) {
        // Se o produto não for encontrado, redireciona para a listagem
        header("Location: list_products.php?status=invalid_id");
        exit();
    }
} catch (PDOException $e) {
    // Erro ao buscar o produto
    header("Location: list_products.php?status=error&msg=" . urlencode($e->getMessage()));
    exit();
}
?>

<div class="container confirmation-box">
    <h2>Confirmar Exclusão de Produto</h2>
    <?php echo $message; // Exibe mensagens de feedback, se houver ?>

    <?php if ($produto): ?>
        <p>Tem certeza que deseja excluir o seguinte produto?</p>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($produto['id']); ?></p>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($produto['nome']); ?></p>
        <p><strong>Preço:</strong> R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
        <?php if (!empty($produto['imagem_path']) && file_exists($produto['imagem_path'])): ?>
            <p><strong>Imagem:</strong></p>
            <img src="<?php echo htmlspecialchars($produto['imagem_path']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" style="max-width: 150px; height: auto; border-radius: 8px; margin-bottom: 15px;">
        <?php else: ?>
            <p><strong>Imagem:</strong> [Sem Imagem]</p>
        <?php endif; ?>
        <p style="color: #dc3545; font-weight: bold;">Esta ação é irreversível e removerá o produto e sua imagem!</p>

        <div class="confirmation-actions">
            <!-- Formulário para confirmar a exclusão (POST) -->
            <form action="confirm_delete_product.php" method="POST" style="display: inline;">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($produto['id']); ?>">
                <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($produto['imagem_path'] ?? ''); ?>">
                <button type="submit" name="confirm_delete" value="true" class="action-button delete-button">
                    Sim, Excluir Definitivamente
                </button>
            </form>

            <!-- Botão para cancelar a exclusão (GET) -->
            <a href="list_products.php?status=cancelled" class="action-button back-button">
                Não, Voltar para a Lista
            </a>
        </div>
    <?php else: ?>
        <p>Produto não encontrado ou ID inválido.</p>
        <p><a href="list_products.php" class="action-button back-button">Voltar para a lista de produtos</a></p>
    <?php endif; ?>
</div>

<?php
// Inclui o rodapé HTML.
require_once 'includes/bottom.php';
?>
