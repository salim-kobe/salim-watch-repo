<?php
session_start();
class RegisterController extends ConnexionUser
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
		//On instancie l'objet UserModel
		$userModel  = new UserModel();
		
		//On vérifie que tous les champs sont renseignés
        $verifEmpty = $userModel->verifyEmpty($_POST); 
        
        if ($verifEmpty === true) {

			//Si tous les champs ont bien été renseignés, on vérifie que le mail entré n'existe pas déjà
            $checkMail = $userModel->checkMail(); 
			
            if ($checkMail === true) { 

				//Si le mail entré n'existe pas déjà dans la bdd, on ajoute un utilisateur
                $insertUser = $userModel->insertUser(); 
                
				if ($insertUser === true) { 
					
					//si l'utilisateur a bien était ajouté dans la bdd, on instancie l'objet ConnexionUser
					$utiUtil = new ConnexionUser();
					
					//On connecte directement l'uitlisateur
					$retour  = $utiUtil->login($_POST['email'], $_POST['password']); 
					
					//Redirection vers la page d'accueil
                    $http->redirectTo('/'); 
                } else {

					//On affiche une message d'erreur si il y a une erreur dans le formulaire
                    $errorRegister = new FlashBag(); 
					$errorRegister->add('Une erreur est survenue dans le formulaire, veuillez recommencer'); //Ajout du message dans la variable $errorRegister
					return ['errorRegister' => $errorRegister];
                }
            } else {

				//On affiche une message d'erreur si il l'adresse mail entré existe déjà
                $errorMail = new FlashBag();
				$errorMail->add('Il existe déjà un compte utilisateur avec cette adresse e-mail'); 
				return ['errorMail' => $errorMail];
            }
        } else {

			//On affiche une message d'erreur si tous les champs du formulaire n'ont pas été remplis
            $errorEmpty = new FlashBag(); 
			$errorEmpty->add('Veuillez remplir tous les champs du formulaire'); 
			return ['errorEmpty' => $errorEmpty];
        }
         
    }
}

