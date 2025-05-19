
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="fonction.js" defer></script>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body id="co">

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
    </header> 




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

// Traitement modification infos utilisateur
if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_infos'])) {
    $nouveau_nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $nouvel_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $nouveau_password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($nouveau_nom && $nouvel_email) {
        $sql = "UPDATE users SET nom = ?, email = ?" . ($nouveau_password ? ", password = ?" : "") . " WHERE id = ?";
        if ($nouveau_password) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nouveau_nom, $nouvel_email, $nouveau_password, $_SESSION['user']['id']);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $nouveau_nom, $nouvel_email, $_SESSION['user']['id']);
        }
        if ($stmt->execute()) {
            $message = "Informations mises à jour avec succès.";
            $_SESSION['user']['email'] = $nouvel_email;
        } else {
            $message = "Erreur lors de la mise à jour.";
        }
        $stmt->close();
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
    }
}

// Traitement connexion
if (!isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['modifier_infos'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id, nom, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // MODIFICATION ICI : comparaison en clair
            if ($password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'nom' => $user['nom']
                ];
                header('Location: connexion.php');
                exit();
            } else {
                $message = 'Mot de passe incorrect.';
            }
        } else {
            $message = 'Aucun compte trouvé avec cet email.';
        }
        $stmt->close();
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}

$conn->close();
?>

<?php if (isset($_SESSION['user'])): ?>
    <section class="login">
        <h2>Modifier mes informations</h2>
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" action="connexion.php">
            <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['user']['nom']) ?>" required><br><br>
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" required><br><br>
            <input type="password" name="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)"><br><br>
            <button id="sub" type="submit" name="modifier_infos">Enregistrer les modifications</button>
        </form>
        <form method="post" action="deco.php">
            <button class ="deco"type="submit"> <a href = "deco.php">Se déconnecter </button></a>
        </form>
    </section>

<?php else: ?>
    <section class="login">
        <h2>Connexion</h2>
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" action="connexion.php">
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br><br>
            <button id="sub" type="submit">Se connecter</button>
        </form>
    </section>
<?php endif; ?>
</body>
</html>