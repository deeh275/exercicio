<?php
session_start();
require_once 'model/Usuario.php';  
require_once 'dao/UsuarioDAO.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, "password");

    
    $usuarioDAO = new UsuarioDAO(); 
    $usuario = $usuarioDAO->getByEmail($email);

    if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
        $error = "Email ou senha inválidos!";
    } else {
       
        $token = $usuarioDAO->createToken($usuario->getId());

        if ($token) {
           
            $_SESSION['user_id'] = $usuario->getId();
            $_SESSION['user_name'] = $usuario->getNome();
            $_SESSION['token'] = $token; 

            header('Location: list_contacts.php'); 
            exit();
        } else {
            $error = "Erro ao criar token. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-8 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Login</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha:</label>
                <input type="password" id="password" name="password" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Entrar</button>
        </form>
    </div>
</body>
</html>
