<?php
class ConnexionUser
{
    public function __construct()
    {
        
    }
    
    public function login($mail, $motPasse)
    {
        // Récupération des données de connexion de l'utilisateur
        $passCrypte = hash('sha512', $motPasse);
        $db         = new Database;
        $form       = array($mail, $passCrypte);
        $stmt       = $db->queryOne('SELECT Id, FirstName, Email, Password
                                FROM user
                                WHERE Email = ?
                                AND Password = ?', $form);
        
        // Est-ce que l'email et le mot de passe sont corrects par rapport à ceux stockés ?
        if ($mail == $stmt['Email'] && $passCrypte == $stmt['Password']) {
            $_SESSION['id']        = $stmt['Id'];
            $_SESSION['firstName'] = $stmt['FirstName'];
            return true;
            
        } else {
            return false;
        }
    }
    
    public function notConnect()
    {
        // On vérifie si l'utilisateur est connecté ou pas
        if (isset($_SESSION['id'])) {
            return true;
        } else {
            echo 'Vous devez être connecté';
            return false;
        }
    }
}
