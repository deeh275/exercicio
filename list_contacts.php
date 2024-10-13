<?php
session_start();
require_once 'DatabaseRepository.php';

$contacts = DatabaseRepository::getAllContacts();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contatos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Contatos</h1>

    <nav class="mb-4">
        <?php if (isset($_SESSION['token'])): ?>
            <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
            <a href="add_contact.php" class="text-blue-500 hover:underline">Adicionar Novo Contato</a> 
        <?php else: ?>
            <a href="login.php" class="text-blue-500 hover:underline">Login</a>
            <a href="register.php" class="text-blue-500 hover:underline">Cadastrar</a> 
        <?php endif; ?>
    </nav>
    
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nome</th>
                <th class="py-2 px-4 border-b">Telefone</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($contact['nome']); ?></td>
                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($contact['telefone']); ?></td>
                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($contact['email']); ?></td>
                    <td class="py-2 px-4 border-b">
                        <?php if (isset($_SESSION['token'])): ?>
                            <a href="edit_contact.php?id=<?= $contact['id']; ?>" class="text-blue-500 hover:underline">Editar</a>
                            <a href="delete_contact.php?id=<?= $contact['id']; ?>" 
                               onclick="return confirm('Tem certeza que deseja deletar este contato?');" 
                               class="text-red-500 hover:underline">Deletar</a>
                        <?php else: ?>
                            <span>Somente para usuários logados</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
