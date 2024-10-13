<?php
require_once 'DAO/usuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); 

    if (DatabaseRepository::emailExists($email)) {
        echo "Este email já está cadastrado!";
    } else {
        if (DatabaseRepository::registerUser($nome, $email, $senha)) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-8 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Cadastrar Novo Usuário</h1>

        <form method="POST" action="register.php" class="space-y-4">
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome:</label>
                <input type="text" id="nome" name="nome" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <div>
                <label for="senha" class="block text-sm font-medium text-gray-700">Senha:</label>
                <input type="password" id="senha" name="senha" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Cadastrar</button>
        </form>
        
        <a href="login.php" class="text-blue-500 hover:underline mt-4 inline-block">Já tem uma conta? Faça login</a>
    </div>
</body>
</html>
