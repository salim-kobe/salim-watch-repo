<?php
class Contact
{
    
    public function insertMessage($lastName, $email, $message)
    {
        
        $db = new Database;
        
        $form = array(
                $lastName,
                $email,
                $message
        );
        
        // On insère le nom, l'email et le message de l'utilisateur dans la BDD
        $result = $db->executeSql('INSERT INTO contact (Nom, Email, Message, CreationTimestamp)
                                  VALUES(?,?,?,NOW())', $form);
        
        return true;
    }
}

