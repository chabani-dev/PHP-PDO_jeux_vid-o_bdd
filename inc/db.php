<?php

// TODO #1 créer un objet PDO permettant de se connecter à la base de données "videogame"
// et le stocker dans la variable $pdo
// --- START OF YOUR CODE ---

$dsn='mysql:host=localhost;dbname=videogame';
$user='root';

try{
    $pdo=new PDO($dsn,$user);
}catch(Exception $erreur){
    echo '<h1>Erreur de connexion avec la BDD';
    exit;
}




// --- END OF YOUR CODE ---
