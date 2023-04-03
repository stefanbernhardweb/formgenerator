<?php

namespace App\Controller\Area;

use \App\Core\Controller as Controller;
use \App\Core\Session as Session;
use \App\Controller\Authentification as Authentification;
use \App\Model\Form\Form as FormModel;

class Area extends Controller{

    private $formModel;

    public function __construct(){
        $this->formModel = $this->loadModel("Form", "Form");
    }

    /**
     * Diese Funktion wird vom Router zur Anzeige der entsprechenden View ausgeführt. Es wird zusätzlich geprüft, ob der User auch die Rechte hat die angeforderten Seiten aufzurufen
     *
     * @param  string $view
     * @return void
     */

    public function index(string $view, array $get = []){
           
        if($view){

            $view = substr($view, 1, -4);
            
            Authentification::checkRestrictArea($view);  

            $allUserForms = $this->formModel->getAllForms(Session::getSession("userId"));
            $action = isset($_GET["form"]) ? filter_var(trim($_GET["form"]), FILTER_SANITIZE_STRING) : null;
            
            // Zur Einbindung der einzelnen 3rd-Party Bibliotheken aus dem Vendor Ordner
            $data["path"] = "./";

            // Eigene CSS- & JavaScript Dateien für diese Route
            $data["css"] = "<link rel='stylesheet' href='" . $data["path"] . "app/view/assets/styles/area.css'>";
            $data["js"] = "<script src='" . $data["path"] . "app/view/assets/js/area.js'></script>";
        
            switch($view){
                case "area/home":
                    $data["title"] = "Home";
                
                    $data["activeHome"] = "active";
                    $data["activeAccount"] = "";
                    $data["activeApi"] = "";
                    
                    $data["username"] = Session::getSession("username");
                    $data["action"] = "";
                    $data["formHeader"] = "";
                    $data["formTableLabels"] = "";

                    if(count($allUserForms) > 0){
                        $data["formHeader"] = "<h5 class='mb-4 mt-5'>Deine Formulare</h5>";
                        $data["formTableLabels"] = ' <div class="row border-bottom mt-3 pe-3">
                                                        <div class="col-10">
                                                            <p class="fs-6 fw-bold">Formularname<p>
                                                        </div>
                                                        <div class="col-2 d-flex flex-row-reverse">
                                                            <p class="fs-6 fw-bold">Aktionen</p>
                                                        </div>
                                                    </div>';
                    }

                    if(!empty($action)){
                        if($action == "created"){
                            $data["action"] = "<div class='alert alert-success mb-3 mt-5 mx-auto w-50'>
                                                <p class='text-center text-success fw-bold mb-0 mt-0'>Das Formular wurde erfolgreich erstellt!</p>
                                              </div>";
                        }else if($action == "updated"){
                            $data["action"] = "<div class='alert alert-success mb-3 mt-5 mx-auto w-50'>
                                                    <p class='text-center text-success fw-bold mb-0'>Das Formular wurde erfolgreich geupdatet!</p>
                                                </div>";
                        }else if($action == "deleted"){
                            $data["action"] = "<div class='alert alert-success mb-3 mt-5 mx-auto w-50'>
                                                    <p class='text-center text-success fw-bold mb-0'>Das Formular wurde erfolgreich gelöscht!</p>
                                                </div>";
                        }
                    }
                        
                    
                    $data["forms"] = $allUserForms;
                    
                    
                    $this->loadView($view, $data);
                    break;
            
            }
        
        }
    }

}

