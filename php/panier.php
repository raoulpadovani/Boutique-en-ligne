<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "<p style='margin-top:120px;text-align:center;color:#8c52ff;font-size:24px;'>Connectez-vous pour accéder à votre panier.</p>";
    exit;
}

// Suppression d'un jeu du panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_index'])) {
    $index = (int)$_POST['remove_index'];
    if (isset($_SESSION['panier'][$index])) {
        array_splice($_SESSION['panier'], $index, 1);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="srcipt.js" defer></script>
       <link rel="stylesheet" href="../css/index.css">
</head>
<body>
<header>
        <div class="tete">
                <a href="../index.php"><img src="../asset/logo/titre.png" alt="logo c" class ="src"  /></a>
                <h1 class="titre">GameMania</h1>
                <a href="ps.php"><img src="../asset/logo/ps.png" alt="logo ps"   /></a>
                <a href="xbox.php"><img src="../asset/logo/xbox.png" alt="logo xbox"   /></a>
                <a href="switch.php"><img src="../asset/logo/switch.png" alt="logo switch"   /></a>
                <a href="login.php"><img src="../asset/logo/connexion.png" alt="logo switch"   /></a>
                <a href="panier.php"><img src="../asset/logo/panier.png" alt="logo switch"   /></a>
                
                <div id="search-container">
                    <input type="text" id="search-bar" placeholder="Rechercher un jeux...">
                    <ul id="autocomplete-list"></ul>
                </div>
        </div>
    </header><br>

<h6>🛒 Votre Panier 🛒</h6><br>
<?php
if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $i => $jeu) {
        echo "<div class='recent'>";
        echo "<img src='" . htmlspecialchars($jeu['image_url']) . "' alt='Image du jeu'><br>";
        echo "<h3>" . htmlspecialchars($jeu['nom_jeu']) . "</h3>";
        echo "<strong>Prix:</strong> " . number_format($jeu['prix']) . " €<br>";
        // Formulaire pour supprimer ce jeu du panier
        echo "<form method='post' action='' style='display:inline;'>";
        echo "<input type='hidden' name='remove_index' value='" . $i . "'>";
        ?> <button class ="supprimer">Supprimer</button>
        <?php
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}
?>
</body>
</html>