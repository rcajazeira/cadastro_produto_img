<?php
// register_product.php
// Página para cadastro de novos produtos com upload de imagem.

// Inclui o arquivo de conexão com o banco de dados.
require_once 'includes/connection.php';
// Inclui o cabeçalho HTML e CSS.
require_once 'includes/head.php';

$message = ''; // Variável para armazenar mensagens de sucesso ou erro

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta e sanitiza os dados do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT); // Valida como float
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_VALIDATE_INT);  // Valida como inteiro

    $imagemPath = null; // Inicializa o caminho da imagem como nulo

    // --- Validação e Processamento do Upload da Imagem ---
    // Verifica se um arquivo foi enviado e se não houve erros
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagem']['tmp_name'];
        $fileName = $_FILES['imagem']['name'];
        $fileSize = $_FILES['imagem']['size'];
        $fileType = $_FILES['imagem']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define o diretório de upload
        $uploadFileDir = './uploads/';
        // Cria um nome de arquivo único para evitar sobrescrever
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $destPath = $uploadFileDir . $newFileName;

        // Tipos de arquivo permitidos
        $allowedFileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        // Validação do tipo e tamanho do arquivo
        if (in_array($fileExtension, $allowedFileExtensions)) {
            if ($fileSize < 5000000) { // Limite de 5MB (5 * 1024 * 1024 bytes)
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $imagemPath = $destPath; // Salva o caminho relativo no banco de dados
                } else {
                    $message = '<div class="message error">Erro ao mover o arquivo de imagem.</div>';
                }
            } else {
                $message = '<div class="message error">O arquivo de imagem é muito grande (máx. 5MB).</div>';
            }
        } else {
            $message = '<div class="message error">Tipo de arquivo de imagem não permitido. Apenas JPG, JPEG, PNG, GIF.</div>';
        }
    } elseif (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Lida com outros erros de upload (ex: UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE)
        $message = '<div class="message error">Erro no upload da imagem: Código ' . $_FILES['imagem']['error'] . '.</div>';
    }

    // --- Validação dos dados do formulário (independentemente do upload) ---
    if (empty($nome) || $preco === false || $estoque === false) {
        $message = '<div class="message error">Por favor, preencha todos os campos obrigatórios corretamente (Nome, Preço, Estoque).</div>';
    } elseif ($preco < 0 || $estoque < 0) {
        $message = '<div class="message error">Preço e Estoque não podem ser negativos.</div>';
    } else {
        // Se não houve erros de upload e os dados são válidos
        if (empty($message)) { // Verifica se a variável $message já não foi preenchida por um erro de upload
            try {
                // Prepara a query SQL para inserir os dados do novo produto
                $stmt = $pdo->prepare("INSERT INTO produto (nome, descricao, preco, estoque, imagem_path) VALUES (:nome, :descricao, :preco, :estoque, :imagem_path)");

                // Binda os parâmetros aos valores
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':descricao', $descricao);
                $stmt->bindParam(':preco', $preco);
                $stmt->bindParam(':estoque', $estoque);
                $stmt->bindParam(':imagem_path', $imagemPath); // Pode ser NULL se nenhuma imagem foi enviada

                // Executa a query
                if ($stmt->execute()) {
                    $message = '<div class="message success">Produto cadastrado com sucesso!</div>';
                    // Opcional: Limpar os campos do formulário após o sucesso
                    $nome = $descricao = $preco = $estoque = '';
                    $imagemPath = null;
                } else {
                    $message = '<div class="message error">Erro ao cadastrar o produto. Tente novamente.</div>';
                }
            } catch (PDOException $e) {
                $message = '<div class="message error">Erro no banco de dados: ' . $e->getMessage() . '</div>';
            }
        }
    }
}
?>

<div class="container">
    <h2>Cadastrar Novo Produto</h2>
    <?php echo $message; // Exibe mensagens de sucesso ou erro ?>
    <form action="register_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>" required class="rounded-lg">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" class="rounded-lg"><?php echo htmlspecialchars($descricao ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?php echo htmlspecialchars($preco ?? ''); ?>" required class="rounded-lg">
        </div>
        <div class="form-group">
            <label for="estoque">Estoque:</label>
            <input type="number" id="estoque" name="estoque" min="0" value="<?php echo htmlspecialchars($estoque ?? ''); ?>" required class="rounded-lg">
        </div>
        <div class="form-group">
            <label for="imagem">Imagem do Produto:</label>
            <input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/gif" class="rounded-lg">
            <small>Formatos permitidos: JPG, PNG, GIF. Tamanho máximo: 5MB.</small>
        </div>
        <button type="submit" class="rounded-lg">Cadastrar Produto</button>
    </form>
    <p class="text-center"><a href="index.php">Voltar para a página inicial</a></p>
</div>

<?php
// Inclui o rodapé HTML.
require_once 'includes/bottom.php';
?>
