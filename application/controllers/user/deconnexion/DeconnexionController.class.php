<?php
session_start();
class DeconnexionController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        // On instancie l'objet DeconnexionUser
        $user = new DeconnexionUser();

        //On appelle la fonction qui va déconnecter l'utilisateur
        $user->deconnexion();

        //On affiche un message de déconnexion
        $disconnect = new FlashBag();
        $disconnect->add('vous êtes maintenant déconnecté');
        return ['disconnect' => $disconnect];
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        
    }
}

