<?php


// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=gamemania', 'root', '');

// Récupérer l'image passée en GET
$image = isset($_GET['image']) ? $_GET['image'] : '';

if ($image) {
    // Chercher le jeu dans la table produits avec l'image
    $stmt = $pdo->prepare('SELECT nom, prix, description, image_url FROM produits WHERE image_url = ?');
    $stmt->execute([$image]);
    $jeu = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $jeu = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du jeu</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <button id="retour"><a class="retour" href="javascript:history.back()">← Retour</a></button>
    <section class="detail">
        <?php if ($jeu): ?>
            <img src="<?php echo htmlspecialchars($jeu['image_url']); ?>">
            <h5><?php echo htmlspecialchars($jeu['nom']); ?></h5>
            <h5>Prix : <?php echo number_format($jeu['prix']); ?> €</h5>
            <p><?php echo nl2br(htmlspecialchars($jeu['description'])); ?></p>
        <?php else: ?>
            <p>Jeu non trouvé.</p>
        <?php endif; ?>
    </section>
    <section class="detail2">
        <?php if ($jeu): ?>
            <form action="php/ajouter_panier.php" method="post">
                <input type="hidden" name="nom_jeu" value="<?php echo htmlspecialchars($jeu['nom']); ?>">
                <input type="hidden" name="image_url" value="<?php echo htmlspecialchars($jeu['image_url']); ?>">
                <input type="hidden" name="prix" value="<?php echo htmlspecialchars($jeu['prix']); ?>">
                <button type="submit">
                    <img src="asset/logo/panier.png" alt="Ajouter au panier">
                </button>
            </form>
        <?php endif; ?>
    </section>
</body>
</html>