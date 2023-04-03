<?php

namespace App\Controller\Api;

use App\Core\Controller as Controller;
use App\Core\Session as Session;
use App\Controller\Email as Email;
use App\Controller\Authentification as Authentification;


class Api extends Controller{

    private $apiModel;

    public function __construct(){
        $this->apiModel = $this->loadModel("Api", "Api");  
    }
    
    /**
     * Diese Funktion wird vom Router zur Anzeige der entsprechenden View ausgeführt. Es wird zusätzlich geprüft, ob der User auch die Rechte hat die angeforderten Seiten aufzurufen
     *
     * @param  string $view
     * @return void
     */

    public function index(string $view){
           
        if($view){

            $view = substr($view, 1, -4);
            
            Authentification::checkRestrictArea($view);  
            
            // Zur Einbindung der einzelnen 3rd-Party Bibliotheken aus dem Vendor Ordner
            $data["path"] = "./";

            // Eigene CSS- & JavaScript Dateien für diese Route
            $data["css"] = "";
            $data["js"] = "<script src='" . $data["path"] . "app/view/assets/js/api.js'></script>";

            $apiCode = $this->apiModel->getApiCodeOfUser(Session::getSession("userId"));
        
            switch($view){
                case "api/start":
                    $data["title"] = "API";
                    $data["activeHome"] = "";
                    $data["activeAccount"] = "";
                    $data["activeApi"] = "active";
                    $data["requestForm"] = "";
                    $data["apiCode"] = "";

                    if(count(get_object_vars($apiCode)) === 0){
                        $data["requestForm"] = '<form method="POST">
                                                    <button name="requestAccess" class="btn btn-primary text-center">Generiere dir jetzt deinen API-Schlüssel!</button>
                                                </form>';

                        
                    }else{
                        $data["apiCode"] = ' <div class="alert alert-info text-center mx-auto">
                                                <p class="mb-0 text-break"><strong>Dein API-Schlüssel:</strong> <br><span id="apiKey">' . $apiCode->apiCode . '</span>  <button id="copyApiKey" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Kopiere deinen API-Code"><i class="fas fa-copy"></i></button></p>
                                            </div>';
                    }
                    
                    
                   
                                  
                    $this->loadView($view, $data);
                    break;
            
            }
        
        }
    }

   
    public function getFormOverApi(array $post){
        $authentification = new Authentification();

        $userAuthetificate = $authentification->authentificateApiAccess($post);
        
        if(!$userAuthetificate){
            echo "Fehler: Name, API-Code & Formular-Id stimmen nicht überein!";
        }else{
           
            $sourceFilesOfForm = $this->apiModel->getSourceFilesOfForm($userAuthetificate["form"], $userAuthetificate["userId"]);

            if(count(get_object_vars($sourceFilesOfForm)) > 0){
                echo json_encode($sourceFilesOfForm);
            }else{
                echo "Es kann kein Formular unter dem angegebenen Namen gefunden werden!";
            }
           
        }
    }

    
}