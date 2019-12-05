<?php

abstract class Form //abstract = ne peut être instanciée (et donc créer d'objet).
{
    private $errorMessage;

    private $formFields;


    abstract public function build(); //construire


    public function __construct()
    {
        $this->errorMessage = null;
        $this->formFields   = array();
    }

    protected function addFormField($name, $value = null) //ajouter un champ de formulaire
    {
        $this->formFields[$name] = $value;
    }

    public function bind(array $formFields) // lier
    {
        $this->build();

        foreach($formFields as $name => $value)
        {
            if(array_key_exists($name, $this->formFields) == true)
            {
                $this->formFields[$name] = $value;
            }
        }
    }

    public function getErrorMessage() //obtenir un message d'erreur
    {
        return $this->errorMessage;
    }

    public function getFormFields() //obtenir des champs de formulaire
    {
        return $this->formFields;
    }

    public function hasFormFields() //contient des champs de formulaire
    {
        return empty($this->formFields) == false;
    }

    public function setErrorMessage($errorMessage) //définir un message d'erreur
    {
        $this->errorMessage = $errorMessage;
    }
}