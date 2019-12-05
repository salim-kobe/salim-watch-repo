<?php

class FlashBag //message flash (permet de stocker des informations et de les effacer 
                //tout de suite après les avoir affichées.)
{
    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }

        //Avons-nous déjà un flash bag?
        if(array_key_exists('flash-bag', $_SESSION) == false)
        {
            // No, create it.
            $_SESSION['flash-bag'] = array();
        }
    }

    public function add($message)
    {
        // Ajoutez le message spécifié à la fin du flash bag
        array_push($_SESSION['flash-bag'], $message);
    }

    public function fetchMessage() //récupérer le message
    {
        // Consommez le message de flash bag le plus ancien.
        return array_shift($_SESSION['flash-bag']);
    }

    public function fetchMessages() //récupérer les messages
    {
        // Consommez tous les messages du flash bag.
        $messages = $_SESSION['flash-bag'];

        // Le flash bag est maintenant vide.
        $_SESSION['flash-bag'] = array();

        return $messages;
    }

    public function hasMessages() //contient un message
    {
        // Avons-nous des messages dans le flash bag ?
        return empty($_SESSION['flash-bag']) == false;
    }
}