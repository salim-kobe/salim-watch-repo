<?php
session_start();
class ListProductsController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        // On instancie l'objet WatchModel
        $watchs = new WatchModel();

        // On appelle la fonction qui permet d'afficher toutes les montres
        $watch  = $watchs->showWatchs();
        return ['watch' => $watch];
        
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        
    }
    
    
}





