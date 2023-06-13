<?php
//?documentation https://www.php.net/manual/fr/language.exceptions.php

//!cette fonction lance un exeption si $chaine est vide
function testChaine($chaine)
{
    if(strlen($chaine) === 0) {
        throw new Exception('Erreur : la chaine est vide');
    }
}

//!provoque une erreur (exception) que l'on n'attrape pas
//testChaine('');


//!bout de code pour lequel si jamais une erreur se produit, nous lançons un traitement alternatif
try {
    testChaine('');
} catch(Exception $error) {

    echo 'Le script a planté';
    echo __FILE__.':'.__LINE__; exit();


    echo '<div>';
        echo 'La chaine est vide ; il faudrait qu\'elle ne le soit pas';
        echo "L'erreur s'est produite dans le fichier " . $error->getFile();
    echo '</div>' ;

    echo '<div style="border: solid 2px #F00">';
        echo '<div style="; background-color:#CCC">@'.__FILE__.' : '.__LINE__.'</div>';
        echo '<pre>';
        print_r($error);
        echo '</pre>';
    echo '</div>';
}




