<?php
session_start();
include('constants.php');

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$total_slots = 35;
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM itens LIMIT $total_slots";
$result = $conn->query($sql);
$itens = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $itens[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Zelda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
              .background {
            background-image: url('https://wallpapercave.com/wp/wp9383694.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            filter: blur(10px);
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .container {
            display: flex;
            height: 100vh;
            padding: 0;
            margin: 0;
        }
        .inventory-box {
            width: 80%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(9, 1fr);
            gap: 10px;
            position: relative;
        }
        .small-item {
            background-color: rgba(255, 255, 255, 0.4);  
            border: 2px solid rgba(255, 255, 255, 0.6);  
            width: 100%;
            height: 100%;
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .small-item:hover, .small-item:active {
            background-color: white;
            transform: scale(1.1);
        }
        .small-item img {
            width: 80%;
            height: 80%;
            object-fit: contain;
            mix-blend-mode: multiply;
            filter: brightness(1.2);  
        }
        .character-image {
            width: 40%;
            height: 100vh;
            background-image: url('https://pluspng.com/img-png/link-zelda-png-zelda-link-png-hd-622.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            position: absolute;
            right: 0;
            top: 0;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between; 
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%; 
            padding: 0;
        }

    .logout-btn, .logout-btn-cadastro {
    width: 48%;
    padding: 10px;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
    transition: all 0.3s ease;
}

.logout-btn {
    background-color: #000; 
    width: 522px;
    height: 55px;
}

.logout-btn-cadastro {
    background-color: #000;
    width: 522px;
    height: 55px;
}



        
.item-info {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            width: 460px;
            height: auto;
            max-height: 150px;
            text-align: left;
            overflow: hidden;
}
        
.item-info img {
            width: 100px; 
            height: 100px;  
            margin-right: 15px;
            object-fit: contain;
            background-color: transparent; 
            border-radius: 5px; 
}
    </style>
    <script>
        function showItemInfo(image, name, description) {
            let infoBox = document.getElementById('item-info');
            infoBox.innerHTML = `
                <div style="display: flex; align-items: center;">
                    <img src="${image}" alt="${name}" style="width: 100px; height: 100px; margin-right: 20px; object-fit: contain;">
                    <div>
                        <strong>${name}</strong><br>
                        ${description}
                    </div>
                </div>
            `;
            infoBox.style.display = 'block';
        }

        function hideItemInfo() {
            document.getElementById('item-info').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <div class="inventory-box">
            <?php 
            for ($i = 0; $i < $total_slots; $i++): 
                if (isset($itens[$i])) {
                    $item = $itens[$i];
                    echo "<div class='small-item' onclick=\"showItemInfo('{$item['imagem']}', '{$item['nome']}', '{$item['descricao']}')\">
                            <img src='{$item['imagem']}' alt='{$item['nome']}' />
                          </div>";
                } else {
                    echo "<div class='small-item' onclick=\"showItemInfo('', 'Vazio', 'Nenhum item neste slot')\"></div>";
                }
            endfor;
            ?>
            <div class="buttons-container">
                <form method="POST" action="logout.php" style="display:inline;">
                    <button type="submit" class="logout-btn">Sair</button>
                </form>
                <form method="GET" action="cadastro_item.php" style="display:inline;">
                    <button type="submit" class="logout-btn-cadastro">Cadastrar novo item</button>
                </form>
            </div>
        </div>
        <div class="character-image"></div>
        <div id="item-info" class="item-info"></div>
    </div>
</body>
</html>
