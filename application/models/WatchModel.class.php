<?php

class WatchModel
{
    
    // Propriétés
    protected $id;
    protected $name;
    protected $photo;
    protected $description;
    protected $Price;
    
    
    // Constructeur
    public function __construct()
    {
        
    }
    
    
    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    
    
    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPhoto()
    {
        return $this->photo;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getPrice()
    {
        return $this->price;
    }
    
    
    
    // Méthode qui appelle la méthode privée getDatasWatch()
    public function showWatchs()
    {
        foreach ($_GET as $key => $val) {
            $method = 'set' . $key;
            $this->$method($val);
        }
        $result = $this::getDatasWatch();
        
        return $result;
    }
    

    // Méthode qui récupère les données des montres
    private static function getDatasWatch()
    {
        $db = new Database;
        
        $result = $db->query('SELECT Id AS id, Name AS name, 
                              Photo AS photo, Description AS description,
                              Price AS price
                              FROM watch');
        
        return $result;
    }
    
    
    // Méthode qui appelle la méthode privée getDataShowProduct($id) et implémente les setters
    public function showProduct($id)
    {
        foreach ($_GET as $key => $val) {
            $method = 'set' . $key;
            $this->$method($val);
        }
        $result = $this->getDataShowProduct($id);
        
        return $result;
    }
    

    // Méthode qui récupère les données d'une seule montre
    private function getDataShowProduct($id)
    {
        $db = new Database;
        
        $id =   array(
                $this->id
                );
        
        $result = $db->query('SELECT Id AS id, Name AS name, 
                              Photo AS photo, Description AS description, Price AS price
                              FROM watch
                              WHERE Id = ?', $id);
        
        return $result;
        
    }
    
}

