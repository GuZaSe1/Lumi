<?php
require 'templates/navbar.php';

session_start();
navbar('home');

$usuario_adm = "administrador@lumi.com.br";
$senha_adm = "admin1234";

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha   = $_POST['senha'] ?? '';

    if ($usuario === $usuario_adm && $senha === $senha_adm) {
        $_SESSION['logado'] = true;
        header("Location: gerenciar_pedidos.php");
        exit;
    } else {
        $msg = "Usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
    <div class="login-box">
        <form method="post">
            <h2 class="text-login">Login</h2>

            <?php if ($msg): ?>
                <div class="erro-login"><?= $msg ?></div>
            <?php endif; ?>

            <input class="input-login" type="text" name="usuario" placeholder="Usuário" required>
            <input class="input-login" type="password" name="senha" placeholder="Senha" required>

            <button class="btn-login" type="submit">Entrar</button>
        </form>
    </div>

</body>

</html>