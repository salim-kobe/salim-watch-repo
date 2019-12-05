<?php
session_start();
class ConnexionController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        // On instancie l'objet ConnexionUser
        $utiUtil = new ConnexionUser();
        
        //On sécurise le formulaire contre les failles 
        $_POST['email']    = htmlentities($_POST['email']); 
        $_POST['password'] = htmlentities($_POST['password']);
        
        //Si les deux variables sont déclarées
        if (isset($_POST['email']) && isset($_POST['password'])) { 

            //On appelle la fonction qui permet de connecter l'utilisateur
            $retour = $utiUtil->login($_POST['email'], $_POST['password']);

        } //Si l'utilisateur a bien été connecté
        if ($retour === true) {
            // Redirection vers l'accueil
            $http->redirectTo('/'); 

            //Sinon on affiche un message d'erreur
        } else {
            $errorConnect = new FlashBag(); 
            $errorConnect->add('Ce compte n\'est pas reconnu'); 
            return ['errorConnect' => $errorConnect];
        }
    }
    
}

