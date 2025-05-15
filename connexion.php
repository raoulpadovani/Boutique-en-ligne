<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="fonction.js" defer></script>
    <link rel="stylesheet" href="index.css">
</head>
<body id="co">
<header>
        <div class="tete">
                <a href="index.php"><img src="asset/logo/titre.png" alt="logo c" class ="src"  /></a>
                <h1 class="titre">GameMania</h1>
                <a href="ps.php"><img src="asset/logo/ps.png" alt="logo ps"   /></a>
                <a href="xbox.php"><img src="asset/logo/xbox.png" alt="logo xbox"   /></a>
                <a href="switch.php"><img src="asset/logo/switch.png" alt="logo switch"   /></a>
                <a href="login.php"><img src="asset/logo/connexion.png" alt="logo switch"   /></a>
                <a href="panier.php"><img src="asset/logo/panier.png" alt="logo switch"   /></a>
                
                <div id="search-container">
                    <input type="text" id="search-bar" placeholder="Rechercher un jeux...">
                    <ul id="autocomplete-list"></ul>
                </div>
        </div>
    </header>




<section class = "login">
    <h2>Connexion</h2>
    <form method="POST" action="connexion.php">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <button id="sub" type="submit">Se connecter</button>
    </form>
</section>
    </section>



<?php
session_start();


$host = "localhost";
$user = "root";
$pass = "";
$db   = "gamemania";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erreur connexion : " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email && $password) {
        
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $email
                ];
                header('Location: index.php');
                exit();
            } else {
                $message = 'Mot de passe incorrect.';
            }
        } else {
            $message = 'Aucun compte trouvé avec cet email.';
        }
        if ($stmt->execute()) {
            echo "<script>alert('Vous êtes connecter !');</script>";
            exit;
        } 

        $stmt->close();
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
    

}

$conn->close();
?>