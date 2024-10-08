<?php

require_once 'DatabaseRepository.php';
$id = $_GET['id'];
$contact = DatabaseRepository::getContactById($id);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    DatabaseRepository::updateContact($id, $nome, $telefone, $email);
    header('Location: list_contacts.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contato</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Adicionar Contato</h1>

    <form action="edit_contact.php?id=<?= $contact['id']; ?>" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required value="<?= $contact['nome'] ?>">
        <br>
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required value="<?= $contact['telefone'] ?>">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required value="<?= $contact['email'] ?>">
        <br>

        <button type="submit">Salvar</button>
    </form>

    <a href="list_contacts.php">Voltar para a lista de contatos</a>
</body>

</html>