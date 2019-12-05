<?php
session_start();
class SearchController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        //On sécurise le formulaire contre les failles 
        $_GET["search"] = htmlentities($_GET["search"]); 
        $createSearch   = new Search();
        $search         = $_GET["search"];

        //On renvoie une chaîne en minuscules
        $search         = strtolower($search);

        //On supprime les espaces dans la requête de l'internaute
        $search         = trim($search); 

        //On supprime les balises html et php dans la requête
        $search         = strip_tags($search); 
        
        $resultSearch = $createSearch->search($search);
        
        // Si la recherche a abouti, on retourne le résultat
        if ($resultSearch == !false) {
           return ['resultSearch' => $resultSearch];

        // Sinon on retourne un message d'erreur
        } else {
            $errorSearch = new FlashBag(); 
            $errorSearch->add('Nous n\'avons pas trouvé d\'articles correspondant à votre recherche.'); //Ajout du message dans la variable $errorSearch
            return ['errorSearch' => $errorSearch];
        }
    }
}

