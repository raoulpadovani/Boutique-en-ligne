<?php


class Database
{
    private static ?\PDO $instance = null;

    private function __construct() {} // Empêche l’instanciation directe

    public static function getInstance(): \PDO
    {
        if (self::$instance === null) {
            $host = "localhost";
            $dbname = "gamemania";
            $user = "root";
            $pass = "";

            self::$instance = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }

        return self::$instance;
    }
}

$conn = Database::getInstance();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
$query = $conn->prepare("SELECT * FROM produits WHERE nom LIKE :search");
$query->bindValue(':search', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);

?>