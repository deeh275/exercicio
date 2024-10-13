<?php

class DatabaseRepository {
    private static $dsn = 'mysql:host=localhost;dbname=contatos';
    private static $username = 'root';
    private static $password = '';

    public static function connect() {
        try {
            $pdo = new PDO(self::$dsn, self::$username, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Falha de Conexao: ' . $e->getMessage();
            exit;
        }
    }

    public static function getAllContacts() {
        $pdo = self::connect();
        $sql = "SELECT * FROM contatos_info";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }

    public static function getContactById($id) {
        $pdo = self::connect();
        $sql = "SELECT * FROM contatos_info WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insertContact($nome, $telefone, $email) {
        $pdo = self::connect();
        $sql = "INSERT INTO contatos_info (nome, telefone, email) 
                VALUES (:nome, :telefone, :email)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'email' => $email]);
    }

    public static function updateContact($id, $nome, $telefone, $email) {
        $pdo = self::connect();
        $sql = "UPDATE contatos_info SET nome = :nome, telefone = :telefone, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'nome' => $nome, 'telefone' => $telefone, 'email'=> $email]);
    }

    public static function deleteContact($id)
    {
        $pdo = self::connect();
        $sql = "DELETE FROM contatos_info WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }


}




