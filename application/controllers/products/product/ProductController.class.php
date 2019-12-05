<?php
session_start();
class productController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        // On instancie l'objet WatchModel
        $model = new WatchModel();
        
        // On récupère l'id qui se trouve dans le champs de requête
        $id    = $queryFields['id'];

        // On appelle la fonction qui va afficher le produit correspondant à l'id
        $watch = $model->showProduct($id);

        return ['watch' => $watch];
		
		return ['id' => $id];

    }
    
    public function httpPostMethod(Http $http, array $formFields)
    {
        // La propriété "method" contient la méthode à executer dans la classe
        $method = isset($_POST['method']) ? $_POST['method'] : null;

        // Si la méthode est bien définie dans la classe alors on l'execute
        if (isset($method) && method_exists($this, $method) !== false) {
            $response =  $this->$method($_POST);
        }
        else{
            $response = "0";
        }

        return $response;
    }
    
    // Ajoute une quantité au produit passé en paramètre
    private function addQuantity($params)
    {
        if (isset($params['productId']) && isset($params['quantity'])) {
            $productId = $params['productId'];
            $quantity  = (int) $params['quantity'];
            
            if (isset($_SESSION['cartItems'][$productId])) {
                $_SESSION['cartItems'][$productId] += $quantity;
            } else {
                $_SESSION['cartItems'][$productId] = $quantity;
            }
            return "1";
        }
        
        return "0";
    }
    
    
}
