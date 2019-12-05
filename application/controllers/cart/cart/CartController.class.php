<?php
session_start();

class CartController
{
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

    // Enregistre la commande passée en paramètre dans la BDD
    public function saveCart($datas)
    {
        $result = "0";
        $orderLines = isset($_POST['orderLines']) ? $_POST['orderLines'] : '';
        $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : [];
        $orderLines = json_decode($orderLines, true);

        if (!empty($orderLines)) {

            $order = new OrderModel();
            $userId = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
            $order->setUserId($userId);
            $order->setTotalAmount($totalAmount);
            $orderId = $order->saveOrder();

            if ($orderId) {
                foreach ($orderLines as $data) {
                                    
                    $watchId = $data["id"];
                    $quantity = $data["quantity"];
                    $price = $data["price"];

                    $orderLine = new OrderLineModel();
                    $orderLine->setOrderId($orderId);
                    $orderLine->setWatchId($watchId);
                    $orderLine->setQuantityOrdered($quantity);
                    $orderLine->setPriceEach($price);
                    $response = $orderLine->saveOrderLine();
                }
                $result = "1";
            }
        }
        return $result;
    }
    
    public function httpGetMethod(Http $http, array $queryFields)
    {
	

    }

}