<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Item - The Legend of Zelda</title>

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
            width: 100%;
            max-width: 500px;
        }

        .card h2 {
            font-family: 'Georgia', serif;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 14px;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Cadastro de Item - The Legend of Zelda</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                Erro ao cadastrar o item. Tente novamente.
            </div>
        <?php endif; ?>

        <form action="cadastro_item_process.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="item_name" class="form-label">Nome do Item</label>
                <input type="text" class="form-control" id="item_name" name="item_name" required>
            </div>
            <div class="mb-3">
                <label for="item_description" class="form-label">Descrição (máximo 100 caracteres)</label>
                <textarea class="form-control" id="item_description" name="item_description" rows="3" maxlength="100" required></textarea>
            </div>
            <div class="mb-3">
                <label for="item_image" class="form-label">Imagem do Item</label>
                <input type="file" class="form-control" id="item_image" name="item_image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Item</button>
        </form>
    </div>

</body>
</html>
