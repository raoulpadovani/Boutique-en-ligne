<?php

$host = "localhost";
$db = "gamemania";
$user = "root"; // ou ton nom d'utilisateur
$pass = "";     // ou ton mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

// Requête avec jointure pour récupérer les infos de plateforme (sous-catégorie)
$sql = "SELECT p.nom AS nom_jeu, p.description, p.prix, p.image_url, p.stock, s.nom AS plateforme
        FROM produits p
        JOIN subcategories s ON p.sous_categorie_id = s.id
        WHERE p.sous_categorie_id = 1 LIMIT 2";

$sql2 = "SELECT p.nom AS nom_jeu, p.description, p.prix, p.image_url, p.stock, s.nom AS plateforme
        FROM produits p
        JOIN subcategories s ON p.sous_categorie_id = s.id
        WHERE p.sous_categorie_id = 4 LIMIT 2";

$sql3 = "SELECT p.nom AS nom_jeu, p.description, p.prix, p.image_url, p.stock, s.nom AS plateforme
        FROM produits p
        JOIN subcategories s ON p.sous_categorie_id = s.id
        WHERE p.sous_categorie_id = 3 LIMIT 2";

$stmt = $pdo->query($sql);
$stmt2 = $pdo->query($sql2);
$stmt3 = $pdo->query($sql3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="srcipt.js" defer></script>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <header>
        <div class="tete">
                <a href="index.php"><img src="asset/logo/titre.png" alt="logo c" class ="src"  /></a>
                <h1 class="titre">GameMania</h1>
                <a href="./php/ps.php"><img src="asset/logo/ps.png" alt="logo ps"   /></a>
                <a href="./php/xbox.php"><img src="asset/logo/xbox.png" alt="logo xbox"   /></a>
                <a href="./php/switch.php"><img src="asset/logo/switch.png" alt="logo switch"   /></a>
                <a href="./php/login.php"><img src="asset/logo/connexion.png" alt="logo switch"   /></a>
                <a href="./php/panier.php"><img src="asset/logo/panier.png" alt="logo switch"   /></a>
                
                <div id="search-container">
    <input type="text" id="search-bar" placeholder="Rechercher un jeu...">
    <ul id="autocomplete-list"></ul> 
</div>
        </div>
    </header>
    <img id ="tekken" src="asset/image/tekken.png" alt="logo c"/><br><br>
    <h4>Top Ventes</h4><br>
        <?php
            if ($stmt->rowCount() > 0) {
                while($jeu = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Lien vers detail.php avec image et prix en GET
                    echo "<a href='detail.php?image=" . urlencode($jeu['image_url']) . "&prix=" . urlencode($jeu['prix']) . "' style='text-decoration:none;color:inherit;'>";
                    echo "<div class='recent'>";
                    echo "<img src='" . htmlspecialchars($jeu['image_url']) . "' alt='Image du jeu'><br>";
                    echo "<h3>" . htmlspecialchars($jeu['nom_jeu']) . "</h3>";
                    echo "<strong>Prix:</strong> " . number_format($jeu['prix']) . " €<br>";
                    // Formulaire pour ajouter au panier
echo "<form method='post' action='php/ajouter_panier.php' style='display:inline;'>";
echo "<input type='hidden' name='image_url' value='" . htmlspecialchars($jeu['image_url']) . "'>";
echo "<input type='hidden' name='nom_jeu' value='" . htmlspecialchars($jeu['nom_jeu']) . "'>";
echo "<input type='hidden' name='prix' value='" . htmlspecialchars($jeu['prix']) . "'>";
echo "<button type='submit'><img src = 'asset/logo/panier.png'></button>";
echo "</form>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "Aucun jeu trouvé dans la base de données.";
            }

            if ($stmt2->rowCount() > 0) {
                while($jeu = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    echo "<a href='detail.php?image=" . urlencode($jeu['image_url']) . "&prix=" . urlencode($jeu['prix']) . "' style='text-decoration:none;color:inherit;'>";
                    echo "<div class='recent'>";
                    echo "<img src='" . htmlspecialchars($jeu['image_url']) . "' alt='Image du jeu'><br>";
                    echo "<h3>" . htmlspecialchars($jeu['nom_jeu']) . "</h3>";
                    echo "<strong>Prix:</strong> " . number_format($jeu['prix']) . " €<br>";
                    // Formulaire pour ajouter au panier
echo "<form method='post' action='php/ajouter_panier.php' style='display:inline;'>";
echo "<input type='hidden' name='image_url' value='" . htmlspecialchars($jeu['image_url']) . "'>";
echo "<input type='hidden' name='nom_jeu' value='" . htmlspecialchars($jeu['nom_jeu']) . "'>";
echo "<input type='hidden' name='prix' value='" . htmlspecialchars($jeu['prix']) . "'>";
echo "<button type='submit'><img src = 'asset/logo/panier.png'></button>";
echo "</form>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "Aucun jeu trouvé dans la base de données.";
            }

            if ($stmt3->rowCount() > 0) {
                while($jeu = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                    echo "<a href='detail.php?image=" . urlencode($jeu['image_url']) . "&prix=" . urlencode($jeu['prix']) . "' style='text-decoration:none;color:inherit;'>";
                    echo "<div class='recent'>";
                    echo "<img src='" . htmlspecialchars($jeu['image_url']) . "' alt='Image du jeu'><br>";
                    echo "<h3>" . htmlspecialchars($jeu['nom_jeu']) . "</h3>";
                    echo "<strong>Prix:</strong> " . number_format($jeu['prix']) . " €<br>";
                    // Formulaire pour ajouter au panier
echo "<form method='post' action='php/ajouter_panier.php' style='display:inline;'>";
echo "<input type='hidden' name='image_url' value='" . htmlspecialchars($jeu['image_url']) . "'>";
echo "<input type='hidden' name='nom_jeu' value='" . htmlspecialchars($jeu['nom_jeu']) . "'>";
echo "<input type='hidden' name='prix' value='" . htmlspecialchars($jeu['prix']) . "'>";
echo "<button type='submit'><img src = 'asset/logo/panier.png'></button>";
echo "</form>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "Aucun jeu trouvé dans la base de données.";
            }
        ?>
        
</body>
</html>