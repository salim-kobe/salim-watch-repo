<?php
session_start();
class UserInfoController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        //On instancie l'objet UserModel
        $user = new UserModel();
        
        //On récupère et affiche les informations de l'utilisateur grâce à l'id de session en cours
        $users = $user::getDatasUsers($_SESSION['id']);
        return ['users' => $users];
        
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        
    }
}

	
  



