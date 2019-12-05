<?php
session_start();
class ContactController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        if (isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['email'])) {

			//On instancie l'objet Contact
			$contact = new Contact(); 
			
			//On appelle la fonction qui insère les données
			$insertMessage = $contact->insertMessage($_POST['lastName'], $_POST['email'], $_POST['message']); 
			
            // Si les données ont bien été ajoutées
            if ($insertMessage === true); {

				//On instancie l'objet FlashBag
				$validMessage = new FlashBag(); 
				
				//Ajout du message dans la variable $validMessage
                $validMessage->add('Votre message a bien été envoyé'); 
                return ['validMessage' => $validMessage];
			}
			
		// Si les données n'ont pas été ajoutées
        } else {
            $errorContact = new FlashBag();
			$errorContact->add('Une erreur est survenue dans le formulaire, veuillez recommencer');
			return ['errorContact' => $errorContact];
        }
    }
}
