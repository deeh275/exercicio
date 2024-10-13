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

    public static function emailExists($email) {
        $pdo = self::connect();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM usuario WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function registerUser($nome, $email, $senha) {
        $pdo = self::connect();
        $stmt = $pdo->prepare('INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)');
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        return $stmt->execute();
    }

    public static function getUserByEmail($email) {
        $db = self::connect();
        try {
            $sql = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $usuario ? new Usuario($usuario['id'], $usuario['nome'], $usuario['senha'], $usuario['email'], $usuario['token']) : null;
        } catch (PDOException $e) {
            return null; 
        }
    }

    public static function updateToken($id, $token) {
        $db = self::connect();
        try {
            $sql = "UPDATE usuario SET token = :token WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id, ':token' => $token]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}

class UsuarioDAO {
    public function getByEmail($email) {
        return DatabaseRepository::getUserByEmail($email);
    }

    public function create($usuario) {
        return DatabaseRepository::registerUser($usuario->getNome(), $usuario->getEmail(), $usuario->getSenha());
    }

    public function emailExists($email) {
        return DatabaseRepository::emailExists($email);
    }

    public function createToken($id) {
        $token = bin2hex(random_bytes(16)); 
        return DatabaseRepository::updateToken($id, $token) ? $token : null; 
    }

    public function validateToken($id, $token) {
        $db = DatabaseRepository::connect();
        try {
            $sql = "SELECT * FROM usuario WHERE id = :id AND token = :token";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id, ':token' => $token]);
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false; 
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>