<?php

class DeconnexionUser
{
    public function __construct()
    {
        
    }
    
    public function deconnexion()
    {
        // On détruit la session
        $_SESSION = array();
        session_destroy();
    }
}

