<?php
session_start();
class UserOrderController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        //On crée un tableau vide
        $finalOrder = [];
        
        //On instancie l'objet OrderModel
        $order = new OrderModel();
        
        //On récupère toutes les commandes de l'utilisateur connecté
        $orders = $order::getDatasOrder($_SESSION['id']);
        
        // On boucle pour pouvoir afficher toutes les commandes
        foreach ($orders as $order) {

          //On implémente le tableau à l'intérieur de la boucle pour pouvoir afficher tous les articles de chaque commande
          $finalOrder[$order['Id']][] = [
            'Name' => $order["Name"],
            'Photo' => $order["Photo"],
            'CreationTimestamp' => $order["CreationTimestamp"],
            'QuantityOrdered' => $order["QuantityOrdered"],
            'Price' => $order["Price"],
            'TotalAmount' => $order["TotalAmount"]
          ];
        }
        return ['finalOrder' => $finalOrder]; 
    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        
    }

}

