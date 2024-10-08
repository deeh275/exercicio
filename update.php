<?php
require_once 'DatabaseRepository.php';

// Verifica se o ID foi fornecido na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $contact = DatabaseRepository::getContactById($id);

    if (!$contact) {
        echo "Contato não encontrado.";
        exit;
    }
} else {
    echo "ID não especificado.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $updated = DatabaseRepository::updateContact($id, $nome, $telefone, $email);

    if ($updated) {
       
        header('Location: list_contacts.php');
        exit;
    } else {
        echo "Erro ao atualizar o contato.";
    }exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Contato</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-8 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Alterar Dados</h1>

        <form action="update.php?id=<?= htmlspecialchars($contact['id']); ?>" method="post" class="space-y-4 rounded-1">
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome:</label>
                <input type="text" value="<?= htmlspecialchars($contact['nome']); ?>" name="nome" id="nome" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone:</label>
                <input type="text" name="telefone" value="<?= htmlspecialchars($contact['telefone']); ?>" id="telefone" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" value="<?= htmlspecialchars($contact['email']); ?>" name="email" id="email" required class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Atualizar</button>
        </form>

        <a href="list_contacts.php" class="text-blue-500 hover:underline mt-4 inline-block">Voltar para a lista de contatos</a>
    </div>
</body>
</html>
