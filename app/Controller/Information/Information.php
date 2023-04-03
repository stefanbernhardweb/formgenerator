<?php

namespace App\Controller\Information;

use App\Core\Controller as Controller;
use App\Core\Session as Session;

class Information extends Controller{

     
    /**
     * Diese Funktion wird vom Router zur Anzeige der entsprechenden View ausgeführt. Es wird zusätzlich geprüft, ob der User auch die Rechte hat die angeforderten Seiten aufzurufen
     *
     * @param  string $view
     * @return void
     */
    
    public function index(string $view){
           
        if($view){

            $view = substr($view, 1, -4);
            $sessionExists = Session::sessionsExists();

            // Eigene CSS- & JavaScript Dateien für diese Route
            $data["css"] = '';
            $data["js"] = '';

            $data["path"] = "./";

            if($sessionExists){
                $data["navLink"] = "/project/home";
                $data["nav-link-text"] = "Home";
            }else{
                $data["navLink"] = "./";
                $data["nav-link-text"] = "Zurück";
            }

            switch($view){
                case "information/impressum":
                    $data["title"] = "Impressum";

                    $this->loadView($view, $data);
                    break;
                case "information/datenschutz":
                    $data["title"] = "Datenschutz";
                    $this->loadView($view, $data);
                    break;
            }
            
        }
        
    }
}