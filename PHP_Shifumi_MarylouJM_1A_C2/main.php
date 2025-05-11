<?php
require_once 'game.php';

while (true) {
    echo "\n==== MENU SHIFUMI ====\n";
    echo "1. Nouvelle partie\n";
    echo "2. Afficher l'historique\n";
    echo "3. Afficher les statistiques\n";
    echo "4. Quitter\n";
    echo "Ton choix (1-4) : ";
    $choix = trim(fgets(STDIN));

    if (!in_array($choix, ['1', '2', '3', '4'])) {
        echo "Oups, erreur. Choisis un chiffre entre 1 et 4, s’il te plaît\n";
        continue;
    }

    if ($choix === '1') {
        jouerPartie();
    } elseif ($choix === '2') {
        afficherHistorique();
    } elseif ($choix === '3') {
        afficherStats();
    } elseif ($choix === '4') {
        echo "Merci d’avoir joué, à bientôt !\n";
        exit;
    }
}
?>

