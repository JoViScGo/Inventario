<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color:rgb(81, 127, 255);
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #0c0c0c;
        }
        .rounded-div {
            background-color: #313131;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: 'Arial';
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label, input {
            margin-bottom: 10px;
            width: 100%;
        }
        input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: rgb(97, 97, 97);
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: rgb(173, 173, 173);
        }
        .textbox {
            background-color: rgb(105, 105, 105);
            color: white;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="rounded-div">
        <h1>DIGINVENTORY</h1>
        <p>Seu inventário estudantil digital</p>
        <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
            <p class="error">Usuário ou senha incorretos!</p>
        <?php endif; ?>
        <form action="process_login.php" method="post">
            <label for="usuario">Usuário:</label>
            <input class="textbox" type="text" id="usuario" name="usuario" required>
            <label for="senha">Senha:</label>
            <input class="textbox" type="password" id="senha" name="senha" required>
            <button type="submit"><span style="font-weight: bold; color: rgb(123, 158, 255);">Entrar</span></button>
        </form>
    </div>
</body>
</html>