<?php

namespace App\Model\Api;

use App\Model\Database as Database;

use PDO;
use StdClass;

class Api{

    
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
     * Erstellt einen neuen unverifizierten API-Zugang für den User
     *
     * @param  int $userId
     * @param  string $apiCode
     * @return void
     */
    public function insertNewAccess(int $userId, string $apiCode) : bool{
        $query = "INSERT INTO api (`userId`, `apiCode`) VALUES (?, ?)";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->bindParam(2, $apiCode, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

        

    /**
     * Gibt den API-Code zurück: Für die Anzeige auf der API-Seite
     * 
     * @param int $userId
     * 
     * @return object 
     */

    public function getApiCodeOfUser(int $userId) : object{
        $query = "SELECT `apiCode` FROM api WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $apiCode = $stmt->fetch();
            
        if($apiCode){
            return $apiCode;
        }else{
            return new StdClass();
        }
    }

    /**
     * Gibt den API-Code & API-Access zurück: Für die Anfrage über die API
     * 
     * @param int $userId
     * 
     * @return object 
     */

    public function getApiDataOfUser(int $userId) : object{
        $query = "SELECT `apiCode` FROM api WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $apiData = $stmt->fetch();
    
        if($apiData){
            return $apiData;
        }else{
            return new StdClass();
        }
       
    }

    /**
     * Gibt den HTML- & PHP-Code des Formulars zurück
     * 
     * @param string $formName
     * @param int $userId
     * 
     * @return object 
     */

    public function getSourceFilesOfForm(string $formName, int $userId) : object{
        $query = "SELECT `html`, `php` FROM form WHERE `name` = ? AND `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $formName, PDO::PARAM_STR);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $sourceFiles = $stmt->fetch();
        
        if($sourceFiles){
            return $sourceFiles;
        }else{
            return new StdClass();
        }

    }
}