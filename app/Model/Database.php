<?php

namespace App\Model;

use PDO;

/*

Singelton-Pattern: Es wird nur eine Datenbankverbindung für die gesamte Anwendung aufgebaut.

*/

// TODO: Datenbanzugangdaten anpassen

/**
 * Lokal: 
 * private $dbName = "formgenerator";
 * private $user = "root";
 * private $password = "";
 */

class Database{

    private static $instance = null;
    private $connection;

    private $host = "localhost";
    private $dbName = "db_397719_29";
    private $charset = "utf8";
    private $user = "USER397719_form";
    private $password = "iehYHTR64v";


    private function __construct(){
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}", $this->user, $this->password, array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));   
    }

    /** 
     * Es wird nur eine Instanz der Datenbankverbindung erstellt, wenn noch keine vorhanden ist. Zusätzlich wird diese beim Aufruf der Funktion zurückgegeben.
     * 
     * @return object
    */

    public static function getInstance() : object{
        
        if(self::$instance === null){
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * 
     * Gibt das Datenverbindungs-Objekt zurück, mit dem von außen weitergearbeitet werden kann. 
     * 
     * @return object
     */

    public function getConnection() : object{
        return $this->connection;
    }

    
}