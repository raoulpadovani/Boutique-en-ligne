<?php
$host = "localhost";
$db = "gamemania";
$user = "root"; // ou ton nom d'utilisateur
$pass = "";     // ou ton mot de passe

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Requête avec jointure pour récupérer les infos de plateforme (sous-catégorie)
$sql = "SELECT p.nom AS nom_jeu, p.description, p.prix, p.image_url, p.stock, s.nom AS plateforme
        FROM produits p
        JOIN subcategories s ON p.sous_categorie_id = s.id
        WHERE p.categorie_id = 1 AND p.id = 4"; 
        
        

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="fonction.js" defer></script>
    <link rel="stylesheet" href="index.css">
<body>
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
    <img id ="tekken" src="asset/image/tekken.png" alt="logo c"/><br>
        <?php
            if ($result->num_rows > 0) {
                while($jeu = $result->fetch_assoc()) {
        
                echo "<div class='recent'>";
                echo "<img src='" . htmlspecialchars($jeu['image_url']) . "' alt='Image du jeu'><br>";
                echo "<h3>" . htmlspecialchars($jeu['nom_jeu']) . "</h3>";
                echo "<strong>Prix:</strong> " . number_format($jeu['prix']) . " €<br>";
                echo "<button type='button' onclick='alert(\"Vous avez aimé " . htmlspecialchars($jeu['nom_jeu']) . "!\")'><img src = 'asset/logo/coeur.png'</button>";
                echo "<button type='button' onclick='alert(\"Vous avez ajouté  " . htmlspecialchars($jeu['nom_jeu']) . " au panier !\")'><img src = 'asset/logo/panier.png'</button>";
                echo "</div>";
                }
                } else {
                        echo "Aucun jeu trouvé dans la base de données.";
                        }
                $conn->close();
        ?>
    
    
</body>
</html>
