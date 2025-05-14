<?php
include('constants.php');

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['item_name'];
    $descricao = $_POST['item_description'];
    
    // Verifique se a URL da imagem foi preenchida corretamente
    $imagem = isset($_POST['item_image_url']) ? $_POST['item_image_url'] : '';

    // Verifica se o campo de imagem não está vazio
    if (empty($imagem)) {
        $erro = true; // Se estiver vazio, exibe erro
    }

    // Conectando ao banco de dados
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    if (!$erro) {
        // Preparar e executar o insert
        $stmt = $conn->prepare("INSERT INTO itens (nome, descricao, imagem) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $descricao, $imagem);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = true; // Se falhar, exibe erro
        }

        $stmt->close();
    }
    
    $conn->close();
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Item - Zelda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://wallpaperaccess.com/full/1193446.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            margin: 0;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Cadastro de Item</h2>

    <?php if ($erro): ?>
        <div class="alert alert-danger">Erro ao cadastrar o item. A URL da imagem não pode estar vazia.</div>
    <?php endif; ?>

    <form action="cadastro_item.php" method="POST">
        <div class="mb-3">
            <label for="item_name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="item_name" name="item_name" required>
        </div>
        <div class="mb-3">
            <label for="item_description" class="form-label">Descrição</label>
            <textarea class="form-control" id="item_description" name="item_description" maxlength="100" required></textarea>
        </div>
        <div class="mb-3">
            <label for="item_image_url" class="form-label">URL da Imagem</label>
            <input type="url" class="form-control" id="item_image_url" name="item_image_url" placeholder="https://exemplo.com/imagem.jpg" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
</body>
</html>
