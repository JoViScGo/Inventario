<?php
session_start();

// Inicializa o array de itens vazio
if (!isset($_SESSION['itens'])) {
    $_SESSION['itens'] = [];
}

// Processa exclusão de item
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $_SESSION['itens'] = array_filter($_SESSION['itens'], function($item) use ($id) {
        return isset($item['id']) && $item['id'] !== $id;
    });
    
    // Redireciona para evitar reenvio
    header("Location: ".strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

// Adiciona novo item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_item'])) {
    $novoItem = [
        'id' => uniqid(),
        'nome' => htmlspecialchars($_POST['nome'] ?? 'Novo Item'),
        'desc' => htmlspecialchars($_POST['descricao'] ?? 'Descrição padrão'),
        'img' => htmlspecialchars($_POST['emoji'] ?? '📦')
    ];
    $_SESSION['itens'][] = $novoItem;
    
    // Redireciona para evitar reenvio
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #FEFFEE;
        }
        body {
            display: flex;
            flex-direction: column;
            background-color: #0c0c0c;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 10px;
            background-color: rgb(63, 63, 63);
            color: rgb(81, 127, 255);
        }
        main {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(46, 46, 46);
            padding: 20px;
        }
        .inventario {
            width: 80vw;
            height: 70vh;
            background-color: rgba(63, 63, 63, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(81, 127, 255, 0.3);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .itens-container {
            flex: 1;
            overflow-y: auto;
            margin-top: 15px;
        }
        .item-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(81, 127, 255, 0.2);
            padding-bottom: 15px;
            min-height: 100px;
        }
        .item-img {
            width: 100px;
            height: 100px;
            background-color: #333;
            border: 2px solid rgb(81, 127, 255);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .item-info {
            flex: 1;
        }
        .item-nome {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: rgb(81, 127, 255);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-desc {
            color: #ccc;
            font-size: 0.9rem;
        }
        .btn-adicionar {
            background-color: rgb(81, 127, 255);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
        }
        .btn-adicionar:hover {
            background-color: rgb(60, 100, 220);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(81, 127, 255, 0.3);
        }
        .formulario-item {
            background-color: rgba(63, 63, 63, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            display: none;
        }
        .btn-excluir {
            background: none;
            border: none;
            color: #ff6b6b;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.2s;
            padding: 0;
            margin-left: 10px;
        }
        .btn-excluir:hover {
            color: #ff4444;
            transform: scale(1.1);
        }
        .empty-message {
            text-align: center;
            padding: 20px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <header>
        <h1>Olá, <?php echo htmlspecialchars($_GET['usuario'] ?? 'Usuário'); ?>!</h1>
        <a href="/Exercicio_inventario/login.php">Sair</a>
    </header>
    <main>
        <div class="inventario">
            <h2 class="text-center mb-4">Seu Inventário</h2>
            <div class="itens-container">
                <?php if (empty($_SESSION['itens'])): ?>
                    <div class="empty-message">Nenhum item no inventário</div>
                <?php else: ?>
                    <?php foreach ($_SESSION['itens'] as $item): ?>
                        <div class="item-row">
                            <div class="item-img"><?php echo htmlspecialchars($item['img']); ?></div>
                            <div class="item-info">
                                <div class="item-nome">
                                    <span><?php echo htmlspecialchars($item['nome']); ?></span>
                                    <button class="btn-excluir" onclick="if(confirm('Tem certeza que deseja excluir este item?')) window.location.href='?excluir=<?php echo $item['id']; ?>'">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                                <div class="item-desc"><?php echo htmlspecialchars($item['desc']); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <button id="btnAdicionar" class="btn-adicionar w-100">ADICIONAR</button>
            
            <form id="formItem" class="formulario-item" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome do Item:</label>
                    <input type="text" class="form-control" name="nome" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição:</label>
                    <textarea class="form-control" name="descricao" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Emoji/Ícone:</label>
                    <input type="text" class="form-control" name="emoji" maxlength="2" value="📦">
                </div>
                <button type="submit" name="novo_item" class="btn-adicionar">Confirmar</button>
            </form>
        </div>
    </main>

    <script>
        // Mostra/oculta o formulário
        document.getElementById('btnAdicionar').addEventListener('click', function() {
            const form = document.getElementById('formItem');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>