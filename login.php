<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="fonction.js" defer></script>
    <script src="srcipt.js" defer></script>
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
    
   <section class="login">
        <h2>Inscription</h2>
        
        <?php if (isset($_GET['message'])): ?>
            <p><?= htmlspecialchars($_GET['message']) ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="text" name="nom" placeholder="Nom" required><br><br>
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br><br>
            <button id ="sub"type="submit">S'inscrire</button>
        </form>
        <p>Déjà inscrit ?<a href="connexion.php">Connectez-vous ici</a></p> 
    </section>
   
    
</body>
</html>


<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gamemania";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($nom && $email && $password) {
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $password]); // PAS DE HASH

        if ($stmt) {
            echo "Inscription réussie ! Vous pouvez vous connecter maintenant.";
            exit;
        }
    }
}
?>
