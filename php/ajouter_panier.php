<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if (isset($_POST['nom_jeu'], $_POST['image_url'], $_POST['prix'])) {
    $jeu = [
        'nom_jeu' => $_POST['nom_jeu'],
        'image_url' => $_POST['image_url'],
        'prix' => $_POST['prix']
    ];
    $_SESSION['panier'][] = $jeu;
}

// Retour à la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
