<?php

// Inclusion du fichier s'occupant de la connexion à la DB (TODO)
require __DIR__.'/inc/db.php'; // Pour __DIR__ => http://php.net/manual/fr/language.constants.predefined.php
// Rappel : la variable $pdo est disponible dans ce fichier
//          car elle a été créée par le fichier inclus ci-dessus

// Initialisation de variables (évite les "NOTICE - variable inexistante")
$videogameList = array();
$platformList = array();
$name = '';
$editor = '';
$release_date = '';
$platform = '';
$platformName = '';
// Si le formulaire a été soumis
if (!empty($_POST)) {
    // Récupération des valeurs du formulaire dans des variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $editor = isset($_POST['editor']) ? $_POST['editor'] : '';
    $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
    $platform = isset($_POST['platform']) ? intval($_POST['platform']) : 0;
    
    // TODO #3 (optionnel) valider les données reçues (ex: donnée non vide)
    // --- START OF YOUR CODE ---
    $messages=[];
    if(empty($name)){
        $messages[]='Veuillez entrer un nom';
    }

    if(strlen($name)<10 || strlen($name)>30){
        $messages[]='Le titre doit contenir entre 10 et 30 caractères';
    }

    if(empty($editor)){
        $messages[]='Veuillez entrer un éditeur';
    }
    if(empty($platform)){
        $messages[]='Veuillez choisir une plateforme';
    }
    // --- END OF YOUR CODE ---
    
    // Insertion en DB du jeu video
    if(empty($messages)){
    $insertQuery = "
        INSERT INTO videogame (name, editor, release_date, platform_id)
        VALUES ('{$name}', '{$editor}', '{$release_date}', {$platform})
    ";
    // TODO #3 exécuter la requête qui insère les données

    $pdo->exec($insertQuery);

    // TODO #3 une fois inséré, faire une redirection vers la page "index.php" (fonction header)
    // --- START OF YOUR CODE ---

    header('Location: index.php');
    exit();
    }
    // --- END OF YOUR CODE ---
}
// Liste des consoles de jeux
// TODO #4 (optionnel) récupérer cette liste depuis la base de données et remplacer $platformList
// --- START OF YOUR CODE ---

$sql="SELECT id,name FROM `platform` ORDER BY name;";
$result=$pdo->query($sql);
$platformList=$result->fetchAll(PDO::FETCH_KEY_PAIR);

// --- END OF YOUR CODE ---

// TODO #1 écrire la requête SQL permettant de récupérer les jeux vidéos en base de données (mais ne pas l'exécuter maintenant)
// --- START OF YOUR CODE ---

$sql = "SELECT videogame.id, videogame.name, videogame.editor, videogame.release_date, platform.name AS platform FROM `videogame` LEFT JOIN `platform` ON platform_id=platform.id ORDER BY videogame.id ASC";

// --- END OF YOUR CODE ---

// Si un tri a été demandé, on réécrit la requête
if (!empty($_GET['order'])) {
    // Récupération du tri choisi
    $order = trim($_GET['order']);
    if ($order == 'name') {
        // TODO #2 écrire la requête avec un tri par nom croissant
        // --- START OF YOUR CODE ---
        
        $sql = "SELECT videogame.id, videogame.name, videogame.editor, videogame.release_date, platform.name AS platform FROM `videogame` LEFT JOIN `platform` ON platform_id=platform.id ORDER BY videogame.name ASC";

        // --- END OF YOUR CODE ---
    }
    else if ($order == 'editor') {
        // TODO #2 écrire la requête avec un tri par editeur croissant
        // --- START OF YOUR CODE ---

        $sql = "SELECT videogame.id, videogame.name, videogame.editor, videogame.release_date, platform.name AS platform FROM `videogame` LEFT JOIN `platform` ON platform_id=platform.id ORDER BY videogame.editor ASC";

        // --- END OF YOUR CODE ---
    }
    else if ($order == 'date') {
        // TODO #2 écrire la requête avec un tri par date croissante
        // --- START OF YOUR CODE ---

        $sql = "SELECT videogame.id, videogame.name, videogame.editor, videogame.release_date, platform.name AS platform FROM `videogame` LEFT JOIN `platform` ON platform_id=platform.id ORDER BY videogame.release_date ASC";

        // --- END OF YOUR CODE ---
    }
    else if ($order == 'platform') {
        // TODO #2 écrire la requête avec un tri par plateforme croissante
        // --- START OF YOUR CODE ---

        $sql = "SELECT videogame.id, videogame.name, videogame.editor, videogame.release_date, platform.name AS platform FROM `videogame` LEFT JOIN `platform` ON platform_id=platform.id ORDER BY platform.name ASC,videogame.name ASC";

        // --- END OF YOUR CODE ---
    }
}
// TODO #1 exécuter la requête contenue dans $sql et récupérer les valeurs dans la variable $videogameList
// --- START OF YOUR CODE ---

$result=$pdo->query($sql);
$videogameList=$result->fetchAll(PDO::FETCH_CLASS);

// --- END OF YOUR CODE ---

if(!empty($_POST['id'])){

    $id=isset($_POST['id']) ? $_POST['id'] : '';

    // TODO #5 construire et exécuter la requête nécessaire (en utilisant $id) à la suppression et penser à la redirection après.
    // --- START OF YOUR CODE ---
    $deleteQuery="DELETE FROM `videogame` WHERE id='{$id}'";
    $pdo->exec($deleteQuery);
    header('Location: index.php');
    exit();
}


// TODO #6 ajouter une plateforme...
if(!empty($_POST['platformName'])){
    $platformName = isset($_POST['platformName']) ? $_POST['platformName'] : '';
    $insertPlatformQuery = "
        INSERT INTO platform (name)
        VALUES ('{$platformName}')
    ";
    $pdo->exec($insertPlatformQuery);
    header('Location: index.php');
    exit();
}
// --- END OF YOUR CODE ---
// Inclusion du fichier s'occupant d'afficher le code HTML
// Je fais cela car mon fichier actuel est déjà assez gros, donc autant le faire ailleurs (pas le métier hein ! ;) )
require __DIR__.'/view/videogame.php';
