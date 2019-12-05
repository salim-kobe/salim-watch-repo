<?php

class OrderModel
{
    // Propriétés
    protected $id;
    protected $userId;
    protected $totalAmount;
    protected $creationTimestamp;
    
    
    // Constructeur
    public function __construct()
    {
        
    }
    
    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }
    public function setCreationTimestamp($creationTimestamp)
    {
        $this->creationTimestamp = $creationTimestamp;
    }
    

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
    public function getCreationTimestamp()
    {
        return $this->creationTimestamp;
    }
    
    
    
    
    // Méthode qui récupère les données des montres
    public static function getDatasWatch()
    {
        $db = new Database;
        
        $result = $db->query('SELECT Id AS id, Name AS name, 
                              Photo AS photo, Description AS description, QuantityInStock AS quantityInStock,
                              Price AS price
                              FROM watch');
        
        return $result;
    }
    
    // Méthode qui récupère les données d'une seule montre
    public static function getDatasWatchFromIds($watchIds)
    {
        $db = new Database;
        
        $result = $db->query('SELECT Id AS id, Name AS name,  
                              Photo AS photo, Description AS description, Price AS price
                              FROM watch
                              WHERE Id IN("' . implode(',', $watchIds) . '"');
        
        return $result;
    }
    
    // Méthode qui insère les commandes dans la table order
    public function saveOrder()
    {
        $db = new Database;
        
        $form = array(
                $this->getUserId(),
                $this->getTotalAmount()
                );
        
        $result = $db->executeSql('INSERT INTO watch.order(User_Id, TotalAmount, CreationTimestamp) 
                                    VALUES (?,?,NOW())', $form);
                                  
        return $result;
        
    }
    
    // Méthode qui récupère les données des commandes d'un seul utilisateur
    public static function getDatasOrder($User_id)
    {
        $db = new Database;
        
        $User_id =  array(
                    $User_id
                    );
        
        $result = $db->query('SELECT watch.Id, watch.Name as Name, watch.Photo, watch.Price, orderline.QuantityOrdered, User_Id, TotalAmount, CreationTimestamp, order.Id
                              FROM watch.order
                              INNER JOIN watch.orderline
                              ON order.Id = orderline.Order_Id
                              INNER JOIN watch.watch
                              ON watch.Id = orderline.Watch_Id
                              WHERE User_Id = ?
                              ORDER BY CreationTimestamp DESC', $User_id);
        
        return $result;
    }
       
}

