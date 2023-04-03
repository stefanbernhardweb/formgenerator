<?php

namespace App\Model\Account;

use PDO;
use StdClass;

use App\Model\Database as Database;

class Account{

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
     * Fügt einen neuen User in die Datenbank ein
     *
     * @param  string $name
     * @param  string $email
     * @param  string $password
     * @param  string $verifyHash
     * @param  bool $apiAccess
     * @param  int $apiCode
     * 
     * @return void
     */

    public function insertUser(string $name, string $email, string $password, string $verifyHash, int $verified) : bool{
        $query = "INSERT INTO user (`name`, `email`, `password`, `verifyHash`, `verified`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $password, PDO::PARAM_STR);
        $stmt->bindParam(4, $verifyHash, PDO::PARAM_STR);
        $stmt->bindParam(5, $verified, PDO::PARAM_INT);
        

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    /**
     * Updatet den Namen des Users
     *
     * @param  string $name
     * @return bool
     */

    public function updateName(int $id, string $name) : bool{
        $query = "UPDATE user SET `name` = ? WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    /**
     * Updatet die E-Mail des Users
     *
     * @param  string $email
     * @return bool
     */

    public function updateEmail(int $id, string $email) : bool{
        $query = "UPDATE user SET `email` = ? WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    
    /**
     * Updatet das Password des Users
     *
     * @param  string $password
     * @return bool
     */

    public function updatePassword(int $id, string $password) : bool{
        $query = "UPDATE user SET `password` = ? WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $password, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            return true;
        }

        return false;
    }

     /**
     * Löscht einen User
     *
     * @param  int $id
     * @return bool
     */

    public function deleteUser(int $id) : bool{
        $query = "DELETE FROM user WHERE `userId` = ? LIMIT 1";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

     /**
     * Gibt die Daten des Users, nach dem Username, für die Registration, den Login & die Sessiongenerierung zurück
     *
     * @param  string $name
     * @return object
     */

    public function getUserByName(string $name) : object{
        $query = "SELECT `userId`, `name`, `password`, `verified` FROM user WHERE `name` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        
        if($stmt->execute()){
            $user = $stmt->fetch();
            
            if($user){
                return $user;
            }
            
            return new StdClass();
        }
    }

    /**
     * Gibt die Daten des Users, nach der E-Mail-Adresse, für die Registration, den Login & die Sessiongenerierung zurück
     *
     * @param  string $email
     * @return object
     */

    public function getUserByEmail(string $email) : object{
        $query = "SELECT `userId`, `name`, `password`, `verified` FROM user WHERE `email` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        
        if($stmt->execute()){
            $user = $stmt->fetch();
            
            if($user){
                return $user;
            }
            
            return new StdClass();
        }
    }

    /**
     * Gibt die Daten des Users für sein Account zurück
     *
     * @param  int $id
     * @return object
     */

    public function getUserById(int $id) : object{
        $query = "SELECT `userId`, `name`, `email` FROM user WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $user = $stmt->fetch();
            return $user;
        }
        
    }
    

    /**
     * Gibt den Hash zurück, mit dem sich der User verifizieren muss. Falls kein User mit der Id gefunden wird, wird ein leeres Objekt zurückgegeben
     *
     * @param  string $email
     * @return object
     */

    public function getVerifyHash(int $userId) : object{
        $query = "SELECT `verifyHash` FROM user WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $verifyHash = $stmt->fetch();

            if(!empty($verifyHash)){
                return $verifyHash;
            }
   
            return new StdClass(); 
        }
        
    }

        
    /**
     * Speichert die erfolgreiche Verifizierung des Users
     *
     * @param  int $userId
     * @return bool
     */
    
    public function updateAccess(int $userId) : bool{
        $query = "UPDATE user SET `verified` = 1 WHERE `userId` = ?";
        $stmt = $this->dbc->prepare($query);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}