<?php

namespace App\Model\Form;

use PDO;
use StdClass;

use App\Model\Database as Database;

class Form{


    private $dbc;

        
    /**
     * Instanziiert die Datenbankklasse und speichert das Verbindungsobjekt in die private Eigenschaft $dbc ab
     *
     * @return void
     */
    
    public function __construct(){
        $db = Database::getInstance();
        $this->dbc = $db->getConnection();   
    }

    /**
     * Speichert das erzeugte Formular in die Datenbank
     *
     * @param  mixed $userId
     * @param  mixed $name
     * @param  mixed $receiver
     * @param  mixed $html
     * @param  mixed $php
     * @param  mixed $downloadLink
     * @return bool
     */
    public function insertForm(int $userId, string $name, string $receiver, string $html, string $php, string $downloadLink) : bool{
        $query = "INSERT INTO form (`userId`,`name`,`receiver`, `html`, `php`, `downloadLink`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->bindParam(2, $name, PDO::PARAM_STR);
        $stmt->bindParam(3, $receiver, PDO::PARAM_STR);
        $stmt->bindParam(4, $html, PDO::PARAM_STR);
        $stmt->bindParam(5, $php, PDO::PARAM_STR);
        $stmt->bindParam(6, $downloadLink, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
    
    /**
     * Gibt 1 Formular des Users zurück
     *
     * @param  int $userId
     * @param  int $formId
     * @return object
     */

    public function getForm(int $userId, int $formId) : object{
        $query = "SELECT `name`, `receiver`, `html`  FROM form WHERE `formId` = ? AND `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $formId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $forms = $stmt->fetch();

        if($forms){
            return $forms;
        }else{
            return new StdClass;
        }
    }

    /**
     * Gibt alle Formulare des Users zurück
     *
     * @param  int $userId
     * 
     * @return object
     */

    public function getAllForms(int $userId) : array {
        $query = "SELECT `formId`, `name`, `downloadLink` FROM form WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $forms = $stmt->fetchAll();

        if($forms){
            return $forms;
        }else{
            return [];
        }
    }

    
    
    /**
     * Updatet das bereits erstellte Formular
     *
     * @param  mixed $userId
     * @param  mixed $formId
     * @param  mixed $name
     * @param  mixed $receiver
     * @param  mixed $html
     * @param  mixed $php
     * @param  mixed $downloadLink
     * @return bool
     */
    public function updateForm(int $userId, int $formId, string $name, string $receiver, string $html, string $php, string $downloadLink) : bool{
        $query = "UPDATE form SET `name` = ?, `receiver` = ?, `html` = ?, `php` = ?, `downloadLink` = ? WHERE `userId` = ? AND `formId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $receiver, PDO::PARAM_STR);
        $stmt->bindParam(3, $html, PDO::PARAM_STR);
        $stmt->bindParam(4, $php, PDO::PARAM_STR);
        $stmt->bindParam(5, $downloadLink, PDO::PARAM_STR);
        $stmt->bindParam(6, $userId, PDO::PARAM_INT);
        $stmt->bindParam(7, $formId, PDO::PARAM_INT);
        
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    
    /**
     * Löscht das Formular
     *
     * @param  int $userId
     * @param  int $formId
     * 
     * @return bool
     */
    
    public function deleteForm(int $userId, int $formId) : bool{
        $query = "DELETE FROM form WHERE `userId` = ? AND `formId` = ? LIMIT 1";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->bindParam(2, $formId, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

}