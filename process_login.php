<?php
// Lista de usuários cadastrados e suas respectivas páginas
$BancoUsuarios = [
    'usuario1' => 'senha1',
    'usuario2' => 'senha2',
    'usuario3' => 'senha3',
    'João' => '123'
];

// Mapeamento de usuários para suas páginas específicas (agora dentro da pasta "Users")
$PaginasUsuarios = [
    'usuario1' => 'Users/Usuario1.php',
    'usuario2' => 'Users/Usuario2.php',
    'usuario3' => 'Users/Usuario3.php',
    'João' => 'Users/Joao.php'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']); // Remove espaços extras
    $senha = trim($_POST['senha']); // Remove espaços extras

    // Verificar se os campos estão vazios
    if (empty($usuario) || empty($senha)) {
        // Redirecionar para a página de login sem exibir mensagem de erro
        header('Location: login.php');
        exit;
    }

    // Verificar se o usuário existe e a senha está correta
    if (isset($BancoUsuarios[$usuario]) && $BancoUsuarios[$usuario] === $senha) {
        // Redirecionar para a página específica do usuário
        if (isset($PaginasUsuarios[$usuario])) {
            header('Location: ' . $PaginasUsuarios[$usuario] . '?usuario=' . urlencode($usuario));
            exit;
        } else {
            // Caso o usuário não tenha uma página específica, redirecionar para uma página padrão
            header('Location: pg_inicial.php');
            exit;
        }
    } else {
        // Redirecionar para a página de login com mensagem de erro
        header('Location: login.php?erro=1');
        exit;
    }
}
?>