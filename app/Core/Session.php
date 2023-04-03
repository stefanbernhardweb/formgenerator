<?php

namespace App\Core;

session_start();

/**
 * Klasse für das Session-Management
 */

class Session{
    
    /**
     * Setzt eine Session
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */

    public static function setSession(string $name, string $value){
        $_SESSION[$name] = $value;
    }
    
    /**
     * Prüft ob Sessions existieren
     *
     * @return bool
     */

    public static function sessionsExists() : bool{
        if(count($_SESSION) === 0){
            return false;
        }

        return true;
    }
    
    /**
     * Gibt den Wert der gewünschten Session zurück
     *
     * @param  string $name
     * @return string
     */

    public static function getSession(string $name) : string{
        
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        } 

        return "";
    }
    
    /**
     * Löscht alle Sessions
     *
     * @return void
     */

    public static function destroySession(){
        session_destroy();
    }
} 