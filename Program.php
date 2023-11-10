<?php
require_once 'User.php';
require_once 'Carte.php';

// Création des utilisateurs (joueurs)
echo "Entrez le pseudo du joueur 1 : ";
$pseudoJoueur1 = trim(fgets(STDIN));

echo "Entrez le pseudo du joueur 2 : ";
$pseudoJoueur2 = trim(fgets(STDIN));

$user1 = new User($pseudoJoueur1, null, 0);
$user2 = new User($pseudoJoueur2, null, 0);

// Création des cartes hautes
$tabCarteHaute = ['valet', 'dame', 'roi', 'as'];

$tabToutesLesCartesBasses = [];
$tabToutesLesCartesHautes = [];

// Création des cartes basses (numérotées de 2 à 10 pour chaque type)
for ($i = 2; $i < 11; $i++) { 
    $tabToutesLesCartesBasses[] = new Carte("$i de coeur", $i, "coeur");
    $tabToutesLesCartesBasses[] = new Carte("$i de pique", $i, "pique");
    $tabToutesLesCartesBasses[] = new Carte("$i de carreau", $i, "carreau");
    $tabToutesLesCartesBasses[] = new Carte("$i de trefle", $i, "trefle");
}

// Création des cartes hautes (valet, dame, roi, as pour chaque type)
$i = 11; // Valeur attribuée aux cartes hautes
foreach ($tabCarteHaute as $carteHaute) {
    $tabToutesLesCartesHautes[] = new Carte("$carteHaute de coeur", $i);
    $tabToutesLesCartesHautes[] = new Carte("$carteHaute de pique", $i);
    $tabToutesLesCartesHautes[] = new Carte("$carteHaute de carreau", $i);
    $tabToutesLesCartesHautes[] = new Carte("$carteHaute de trefle", $i);
    $i++;
}

// Fusion et mélange des cartes basses et hautes
$tabToutesLesCartes = array_merge($tabToutesLesCartesBasses, $tabToutesLesCartesHautes);
shuffle($tabToutesLesCartes);

// Début du jeu
echo "Appuyez sur entrée pour commencer\n";
fgets(STDIN);

// Distribution des cartes
$tailleTotal = count($tabToutesLesCartes);
$tailleMoitie = ceil($tailleTotal / 2);

$premiereMoitie = array_slice($tabToutesLesCartes, 0, $tailleMoitie);
$secondeMoitie = array_slice($tabToutesLesCartes, $tailleMoitie);

$user1->setPaquet($premiereMoitie);
$user2->setPaquet($secondeMoitie);

// Phase de jeu
echo "Appuyez pour lancer la bataille\n";
fgets(STDIN);

$tasGagne1 = []; // Tas gagné du joueur 1
$tasGagne2 = []; // Tas gagné du joueur 2
$tasEnJeu = []; // Cartes actuellement en jeu
$nbTours = 0; // Compteur de tours

$gagnant = false; // Indicateur de fin de jeu

while (!$gagnant) {
    $nbTours++;
    echo "Appuyez pour continuer\n";
    fgets(STDIN);

    // Recharger les paquets à partir des tas gagnés si nécessaire
    if (empty($user1->getPaquet()) && !empty($tasGagne1)) {
        shuffle($tasGagne1);
        $user1->setPaquet($tasGagne1);
        $tasGagne1 = [];
    }
    if (empty($user2->getPaquet()) && !empty($tasGagne2)) {
        shuffle($tasGagne2);
        $user2->setPaquet($tasGagne2);
        $tasGagne2 = [];
    }

    // Vérifier si un des joueurs a perdu
    if ((empty($user1->getPaquet()) && empty($tasGagne1)) || 
        (empty($user2->getPaquet()) && empty($tasGagne2))) {
        $gagnant = true;
        break;
    }

    $paquet1 = $user1->getPaquet();
    $paquet2 = $user2->getPaquet();

    if (empty($paquet1) || empty($paquet2)) {
        continue;
    }

    // Jouer les cartes du haut de chaque paquet
    $carte1 = array_shift($paquet1);
    $carte2 = array_shift($paquet2);

    // On met les cartes jouée dans le tas en jeu
    array_push($tasEnJeu, $carte1, $carte2);

    // Afficher les cartes jouées et nombres de tours
    echo "Tour n°" . $nbTours . "\n";
    echo $user1->getUsername() . " à joué : " . $carte1->afficheCarte() . "\n";
    echo $user2->getUsername() . " à joué : " . $carte2->afficheCarte() . "\n";

    // Déterminer le gagnant du tour
    if ($carte1->getValeur() > $carte2->getValeur()) {
        echo "Le gagnant du tour est " . $user1->getUsername() . "\n";
        $tasGagne1 = array_merge($tasGagne1, $tasEnJeu);
    } elseif ($carte1->getValeur() < $carte2->getValeur()) {
        echo "Le gagnant du tour est " . $user2->getUsername() . "\n";
        $tasGagne2 = array_merge($tasGagne2, $tasEnJeu);
    } else {
        echo "Egalité, les cartes restent en jeu\n";
    }

    // On remet le tas de carte a 0
    $tasEnJeu = [];

    // On réattribue les paquets
    $user1->setPaquet($paquet1);
    $user2->setPaquet($paquet2);

    // Affichage des cartes restantes et des tas gagnés
    echo "\nCartes restantes de " . $user1->getUsername() . " : " . count($paquet1) . "\n";
    echo "Cartes restantes de " . $user2->getUsername() . " : " . count($paquet2) . "\n";
    echo "Cartes dans le tas gagné de " . $user1->getUsername() . " : " . count($tasGagne1) . "\n";
    echo "Cartes dans le tas gagné de " . $user2->getUsername() . " : " . count($tasGagne2) . "\n";
}

// Affichage du gagnant final
if (!empty($user1->getPaquet()) || !empty($tasGagne1)) {
    echo "Le gagnant final est " . $user1->getUsername() . "\n";
} else {
    echo "Le gagnant final est " . $user2->getUsername() . "\n";
}
?>
