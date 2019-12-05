<?php

class UserModel
{
    // Propriétés
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;
    protected $birthDate;
    protected $address;
    protected $city;
    protected $zipCode;
    protected $country;
    protected $phone;
    protected $creationTimestamp;
    
    
    // Constructeur
    public function __construct()
    {
        $this->setValues();
    }
    
    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getZipCode()
    {
        return $this->zipCode;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getCreationTimestamp()
    {
        return $this->creationTimestamp;
    }
    
    
    // Méthode qui récupère les données entrées par l'utilisateur, convertit les caractères grâce à htmlentities et implémente les setters
    public function setValues()
    {
        foreach ($_POST as $key => $val) {
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $val = htmlentities($val);
                $this->$method($val);
            }
        }
    }
    
    // Méthode qui récupère les données d'un seul utilisateur
    public static function getDatasUsers($id)
    {
        $db = new Database;
        
        $id =   array(
                $id
                );
        
        $result = $db->query('SELECT Id AS id, FirstName AS firstName, 
                              LastName AS lastName, Email AS email, Password AS password,
                              BirthDate AS birthDate, Address AS address, City AS city, ZipCode AS zipCode,
                              Country AS country, Phone AS phone, CreationTimestamp AS getCreationTimestamp
                              FROM user
                              WHERE id = ?', $id);
        
        return $result;
    }
    
    
    
    // Méthode qui appelle la méthode privée insertDatasUser()
    public function insertUser()
    {
        $insertUser = $this->insertDatasUser();
        if ($insertUser != null) {
            return true;
        } else {
            return false;
        }
    }
    
    // Méthode qui insère un nouvel utilisateur
    private function insertDatasUser()
    {
        $db = new Database;
        
        $passCrypte = hash('sha512', $this->getPassword());
        
        $form = array(
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $passCrypte,
                $this->getBirthDate(),
                $this->getAddress(),
                $this->getCity(),
                $this->getZipCode(),
                $this->getCountry(),
                $this->getPhone()
                );
        
        $result = $db->executeSql('INSERT INTO user (FirstName, LastName, Email, Password, 
                                    BirthDate, Address, City, ZipCode, Country, Phone, 
                                    CreationTimestamp)
                                    VALUES(?,?,?,?,?,?,?,?,?,?,NOW())', $form);
        
        return $result;
        
    }
    
    
    // Méthode qui vérifie si le mail de l'utilisateur existe déjà dans la BDD
    public function checkMail()
    {
        $db = new Database;
        
        $form = array(
                $this->getEmail()
                );
        
        $result = $db->queryOne('SELECT Email AS email
                                  FROM user
                                  WHERE email = ?', $form);
        
        if (empty($result) == true) {
            return true;
        } else {
            return false;
        }
    }
    
    
    // Méthode qui vérifie si toutes les variables sont remplies 
    public function verifyEmpty($post)
    {
        foreach ($post as $key => $value) {
            $post[$key] = empty($value);
        }
        if ($post[$key] == true) {

            // si toutes les variables ne sont pas remplies = return false
            return false; 
        } else {
            return true;
        }
        
    }
      
}

