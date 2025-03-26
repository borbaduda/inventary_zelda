<?php
session_start();
include('constants.php');

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$predefined_items = [
    ["img/item1.png", "Cogumelo", "Recupera 30% do nível de fome e dá efeito de náusea."],
    ["img/item2.png", "Disco de ouro", "Use para trocas entre cidadãos comerciantes."],
    ["img/item3.png", "Maçã", "Recupera 40% do nível de fome."],
    ["img/item4.png", "Escudo de ferro", "Quando ativado, protege contra danos de explosões e flechas."],
    ["img/item5.png", "Espada de ferro", "+7 de Dano de Ataque"],
    ["img/item6.png", "Lasca de Diamante", "Use para trocas entre cidadãos celestes."],
    ["img/item7.png", "Trevo de 4 folhas", "Quando usado, protege contra qualquer dano (você só pode usar uma vez)."],
    ["img/item8.png", "Poção de visão noturna", "Permite que você enxergue melhor no escuro"],
    ["img/item9.png.jpg", "Osso", "Use para domesticar lobos."],
    ["img/item10.jpg", "Flecha encantada", "Quando atirada, causa efeito de poções."],
    ["img/item11.jpg", "Tronco de árvore", "Transforme-o em tábuas para utilizá-lo."],
    ["img/item12.jpg", "Vela de invocação", "Use para spawnar mobs."],
    ["img/item13.jpg", "Folha de Árvore", "Use para fazer poções."],
    ["img/item14.jpg", "Poção de regeneração", "Use para regenerar a sua vida."],
    ["img/item15.jpg", "Pena", "Use para escrever em livros ou papéis"],
    ["img/item16.jpg", "Armadura de ouro", "Protege contra +7 dano"],
    ["img/item17.jpg", "Livro de escrita", "Use para escrever"],
    ["img/item18.jpg", "Moeda de esmeralda", "Use para trocar com aldeões comerciantes"],
    ["img/item19.jpg", "Arco", "+5 de Dano"],
    ["img/item20.jpg", "Baú", "Armazena itens"],
    ["img/item21.jpg", "Picareta de pedra", "+5 de Dano"],
    ["img/item22.jpg", "Katana", "+10 de Dano"],
    ["img/item23.jpg", "Condensador", "Use para fortificar poções."],
    ["img/item24.jpg", "Poção placebo", "Use para desfazer efeitos de poções ou mobs."],
    ["img/item25.jpg", "Carne Bovina", "Recupera +40% de fome."],
    ["img/item26.jpg", "Peixe", "Recupera +20% de fome."],
    ["img/item28.jpg", "Amuleto", "Enquanto usado, te protege contra qualquer dano."],
    ["img/item29.jpg", "Armadura de Ferro", "Protege contra +5 de dano."],
    ["img/item30.jpg", "Flecha", "+5 de Dano."],
    ["img/item32.jpg", "Adubária", "Aduba terra em 20 blocos quando usada."]
];


$total_slots = 35;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário - The Legend of Zelda</title>
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
                if (isset($predefined_items[$i])) {
                    $item = $predefined_items[$i];
                    echo "<div class='small-item' onclick=\"showItemInfo('$item[0]', '$item[1]', '$item[2]')\">
                            <img src='$item[0]' alt='$item[1]' />
                          </div>";
                } else {
                    echo "<div class='small-item' onclick=\"showItemInfo('Vazio', 'Nenhum item neste slot')\"></div>";
                }
            endfor;
            ?>

          
            <div class="buttons-container">
              
                <form method="POST" style="display:inline;">
                    <button type="submit" name="logout" class="logout-btn">Sair</button>
                </form>

             
                <form method="GET" action="cadastro_item.php" style="display:inline;">
                    <button type="submit" class="logout-btn-cadastro">Cadastre um item</button>
                </form>
            </div>
        </div>
        <div class="character-image"></div>
        <div id="item-info" class="item-info"></div>
    </div>
</body>
</html>
