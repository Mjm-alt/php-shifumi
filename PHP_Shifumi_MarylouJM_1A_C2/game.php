<?php

function jouerPartie() {
    $options = ['pierre', 'feuille', 'ciseaux'];
    $scoreJoueur = 0;
    $scoreOrdi = 0;

    echo "=== Partie lancée ! ===\n";

    while ($scoreJoueur < 3 && $scoreOrdi < 3) {
        echo "\n Quel est ton choix ? (pierre, feuille ou ciseaux):   ";
        echo "\033[31mTapez 'annuler' pour retourner au menu principal \n \033[0m\n";
        $choixJoueur = strtolower(trim(fgets(STDIN)));

        
        if ($choixJoueur === 'annuler') {
            return;
        }

        if ($choixJoueur === '') {
            echo "Choix invalide. Réessayez. \n";
            continue;
        }

        if (!in_array($choixJoueur, $options)) {
            echo "Hmm… Choix invalide. Essaie avec 'pierre', 'feuille', 'ciseaux' ou 'annuler'\n";
            continue;
        }

        $choixOrdi = $options[array_rand($options)];
        echo " L'ordinateur a joué : $choixOrdi\n";

        $resultat = determinerVainqueur($choixJoueur, $choixOrdi);


        if ($resultat === 'egalite') {
            echo " Égalité !\n";
        } elseif ($resultat === 'joueur') {
            echo " Bien joué, tu remportes cette manche !\n";
            $scoreJoueur++;
        } elseif ($resultat === 'ordi') {
            echo "Aïe… l’ordi gagne cette fois \n";
            $scoreOrdi++;
        }

        
        echo " SCORE ACTUEL  → Toi : $scoreJoueur | Ordinateur : $scoreOrdi\n";
    }

    $vainqueur = ($scoreJoueur === 3) ? 'joueur' : 'ordinateur';
    echo $vainqueur === 'joueur' ? " Bravo ! Tu as gagné la partie contre l’ordi !\n" : " L’ordinateur a gagné cette fois... Revanche ?\n";
    enregistrerHistorique($vainqueur);
    mettreAJourStats($vainqueur);

}

function determinerVainqueur($joueur, $ordi) {
    if ($joueur === $ordi) return 'egalite';

    $gagnants = [
        'pierre' => 'ciseaux',
        'feuille' => 'pierre',
        'ciseaux' => 'feuille'
    ];

    return $gagnants[$joueur] === $ordi ? 'joueur' : 'ordi';
}

function enregistrerHistorique($vainqueur) {
    $date = date('Y-m-d H:i:s');
    $ligne = "$date - Gagnant : $vainqueur\n";
    file_put_contents('history.txt', $ligne, FILE_APPEND);
}

function afficherHistorique() {
    echo "\n=== Historique des parties ===\n";
    if (file_exists('history.txt')) {
        echo file_get_contents('history.txt');
    } else {
        echo "Pas encore d’historique… Lance une partie pour en créer un ! \n";
    }
}

function afficherStats() {
    echo "\n=== Statistiques ===\n";

    if (!file_exists('stats.txt')) {
        echo "Aucune donnée pour l’instant. Gagne des parties pour remplir les stats ! \n";
        return;
    }

    $stats = file('stats.txt', FILE_IGNORE_NEW_LINES);
    foreach ($stats as $ligne) {
        echo "$ligne\n";
    }
}

function mettreAJourStats($vainqueur) {
    $stats = [
        'joueur' => 0,
        'ordinateur' => 0
    ];

    if (file_exists('stats.txt')) {
        $lignes = file('stats.txt', FILE_IGNORE_NEW_LINES);
        foreach ($lignes as $ligne) {
            if (strpos($ligne, ':') !== false) {
                [$cle, $valeur] = explode(': ', $ligne);
                if (isset($stats[$cle])) {
                    $stats[$cle] = (int) $valeur;
                }
            }
        }
    }

    $stats[$vainqueur]++;

    $contenu = "";
    foreach ($stats as $cle => $valeur) {
        $contenu .= "$cle: $valeur\n";
    }

    file_put_contents('stats.txt', $contenu);
}

?>