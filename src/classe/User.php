<?php

class UserManager {
    private $pdo;

    public function __construct($host, $dbname, $user, $pass) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function register($nom, $email, $password) {
        if ($this->userExists($email)) {
            return "Un compte avec cet email existe déjà.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $hashedPassword]);

        return $stmt ? "Inscription réussie !" : "Échec de l'inscription.";
    }

    private function userExists($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }
}

?>
