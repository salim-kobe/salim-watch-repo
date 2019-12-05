<?php
class Search
{
    public function __construct()
    {
      
    }
    
    public function Search($search)
    {
        // On lance une recherche sur la BDD si la recherche est non null et est supérieur à 4 lettres
        if ($search == !NULL && strlen($search) > 4) {

            $db = new Database;
            
            $form = array("%" . $search . "%", "%" . $search . "%");

            // On interroge la BDD
			$result = $db->query('SELECT Id, Name, Description, Photo, Price 
                                  FROM watch
                                  WHERE Name LIKE ? OR Description LIKE ?', $form);
            
            return $result;
        } else {
            return false;
        }
    }
}


