<?php

class OrderLineModel
{
    // Propriétés
    protected $id;
    protected $watchId;
    protected $orderId;
    protected $priceEach;
    protected $quantityOrdered;
    
    // Constructeur
    public function __construct()
    {
        
    }
    
    // Setters 
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setwatchId($watchId)
    {
        $this->watchId = $watchId;
    }
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }
    public function setPriceEach($priceEach)
    {
        $this->priceEach = $priceEach;
    }
    public function SetQuantityOrdered($quantityOrdered)
    {
        $this->quantityOrdered = $quantityOrdered;
    }
    
    
    // Getters 
    public function getId()
    {
        return $this->id;
    }
    public function getWatchId()
    {
        return $this->watchId;
    }
    public function getOrderId()
    {
        return $this->orderId;
    }
    public function getPriceEach()
    {
        return $this->priceEach;
    }
    public function getQuantityOrdered()
    {
        return $this->quantityOrdered;
    }

    
    
    
    // Méthode qui récupère les données des montres
    public static function getDatasWatch()
    {
        $db = new Database;
        
        $result = $db->query('SELECT Id AS id, Name AS name, 
                              Photo AS photo, Description AS description, Price AS price
                              FROM watch');
        
        return $result;
    }
    
    // Méthode qui insère les données de commande dans la table orderline
    public function saveOrderLine()
    {
        $db = new Database;
        
        $form = array(
                $this->getQuantityOrdered(),
                $this->getWatchId(),
                $this->getOrderId(),
                $this->getPriceEach()
                );
        
        $result = $db->executeSql('INSERT INTO watch.orderline (QuantityOrdered, Watch_Id, Order_Id, PriceEach) 
                                    VALUES (?,?,?,?)', $form);
        return $result;
        
    }
    
}

