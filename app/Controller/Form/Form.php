<?php

namespace App\Controller\Form;


use App\Core\Controller as Controller;
use App\Core\Session as Session;
use App\Controller\Form\File as File;
use App\Controller\Authentification;
use App\Model\Account\Account as AccountModel;

use DomDocument;
use DomXPath;

class Form extends Controller{


    private $model = null;
        
    /**
     * Es erfolgt die Instanziierung des Account Models
     *
     * @return void
     */

    public function __construct(){
        $this->model = $this->loadModel("Form", "Form");
    }

     /**
     * Diese Funktion wird vom Router zur Anzeige der entsprechenden View ausgeführt. Dieser können Daten über das Array $data übergeben werden
     * Zusätzlich wird geprüft, ob der User auch die Rechte hat die angeforderten Seiten aufzurufen
     *
     * @param  string $view
     * @param  array $data
     * @return void
     */
    
    public function index($view, $data = []){   
        
        if($view){

            $view = substr($view, 1, -4); 
            
            // Zur Einbindung der einzelnen 3rd-Party Bibliotheken aus dem Vendor Ordner
            $data["path"] = "../";
            $data["nav-link-text"] = "Zurück";

            // Eigene CSS- & JavaScript Dateien für diese Route
            $data["css"] = "<link rel='stylesheet' href='" . $data["path"] . "app/view/assets/styles/form.css'>";
            $data["js"] = "<script type='module' src='" . $data["path"] . "app/view/assets/js/form/form.js'></script>";
    

            switch($view){
                case "form/create":
                    $data["title"] = "Neues Formular erstellen";

                    if(Session::getSession("userId")){
                        $data["navLink"] = "/project/home";
                    }else{
                        $data["navLink"] = "/project/";
                    }
                    
                    $this->loadView($view, $data);
                    break;
                case "form/edit":
                    Authentification::checkRestrictArea($view);
                     
                    $data["title"] = "Formular bearbeiten";
                    $data["navLink"] = "/project/home";
                    
                    $this->loadView($view, $data);
                    break;
            
            }
        
        }

    }
    
    /**
     * Lädt aus der Datenbank Formulardaten mit der entsprechenden Formular-Id heraus und baut daraus den HTML-Code für die Update-Funktion 
     * des Formulargenerators 
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */
    
    public function getForm(array $post = [], string $view = ""){
        $formId = (int) $post["formId"];

        
        $form = $this->model->getForm(Session::getSession("userId"), $formId);

        if(count(get_object_vars($form)) > 0 ){
            $data["name"] = $form->name;
            $data["receiver"] = $form->receiver;
            
            $dom = $this->loadDomWithHTML($form->html);
            $formGroups = $this->getFormGroups($dom);

            $formGroupsDom = $this->loadDomWithHTML($formGroups["formGroupsAsString"]);
            $formFieldProperties = $this->getFormFieldTypesAndBackgroundColor($formGroupsDom);



            // Farben der einzelnen Typen als Array hinzufügen
            $html = $this->generateHTMLCodeForFormgenerator($formGroups["formGroups"], $formFieldProperties);
            
           
            $data["form"] = $html["form"];
            $data["submitButton"] = $html["submitButton"];
            $data["formId"] = $formId;
        
        }
        

        $this->index($view, $data);
           
    }
    
    /**
     * Mit der Klasse DomDocument wird das mitgegebene HTML in ein zu bearbeitendes Format gebracht
     *
     * @param  string $html
     * @return object
     */

    private function loadDomWithHTML(string $html) : object{
        $dom = new DomDocument();
        $dom->loadHTML($html);

        return $dom;
    }
    
    /**
     * Die div-Container mit der Klasse .form-group werden einmal als Array und String erfasst.
     * > Den Array um den HTML-Code für den Formulargenerator zusammen zu bauen
     * > Den String um aus diesem die Typen und Hintergrundfarben der einzelnen Formularfelder zu erfassen
     *
     * @param  object $dom
     * @return array
     */

    private function getFormGroups(object $dom) : array{
        $domXPath = new DomXPath($dom);

        $fields = $domXPath->query("//div[contains(@class, 'form-group')]");
        $formGroups = [];
        $formGroupsAsString = "";

        foreach($fields as $key => $field){     
            // Wandle den Nodeknoten in einen String um
            $formGroups[] = $field->C14N();

            // Für das Bestimmen der Feldeigenschaften
            $formGroupsAsString .= $field->C14N(); 
        }

        $formGroupsAsString = str_replace("</input>", "", $formGroupsAsString);
        
       
        return ["formGroups" => $formGroups, "formGroupsAsString" => $formGroupsAsString];
    }
    
    /**
     * Erfasst die Typen und Hintergrundfarben der einzelnen Formularfelder
     *
     * @param  object $formGroupsDom
     * @return array
     */

    private function getFormFieldTypesAndBackgroundColor(object $formGroupsDom) : array{
        
        $labels = $formGroupsDom->getElementsByTagName("label");
       
        $types = [];
        $backgroundColor = [];

        foreach($labels as $label){
            
            $type = explode("f", $label->getAttribute("for"))[0];

            if(substr($type, 0, 8) == "textarea"){
                $type = "textarea";
            }
            
            // Erfasse die Feldtypen und speichere diese ins Array
            switch($type){
                case "text":
                    $types[] = "Einzeiliges Textfeld";
                    $backgroundColor[] = "bg-primary";
                    break;
                case "textarea":
                    $types[] = "Mehrzeiliges Textfeld";
                    $backgroundColor[] = "bg-secondary";
                    break;
                case "email":
                    $types[] = "E-Mail";
                    $backgroundColor[] = "bg-success";
                    break; 
                case "password":
                    $types[] = "Passwort";
                    $backgroundColor[] = "bg-warning";
                    break; 
                case "radiobutton":
                    $types[] = "Radio-Button";
                    $backgroundColor[] = "bg-info";
                    break; 
                case "checkbox":
                    $types[] = "Checkbox";
                    $backgroundColor[] = "bg-dark";
                    break;   
            }
        }

       
        return [$types, $backgroundColor];
    }
    
    /**
     * Baut den HTML-Code für den Formulargenerator zusammen. 
     *
     * @param  array $formGroups
     * @param  array $fieldProperties
     * @return array
     */

    private function generateHTMLCodeForFormgenerator(array $formGroups, array $fieldProperties) : array{
       
        $form = "";
        $submitButton = "";

        $formId = 2;
        $lastFormGroup = end($formGroups);  
        $formGroupsCount = count($formGroups) - 1;
       
        if(count($formGroups) > 0){
            foreach($formGroups as $key => $formGroup){

                $formGroup = str_replace("mt-3", "", $formGroup);
               
                // Es ist der Sendebutton
                if($key === $formGroupsCount){
                    
                    // utf8_decode um die falsche Anzeige von Umlauten und Sonderzeichen zu beheben
                    $submitButton = '<div class="card mt-2 createdFormField" id="field1">
                                        <div class="card-body">' 
                                            . utf8_decode($formGroup) .                 
                                        '</div>
                                        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                                            <span class="badge badge-pill type text-dark">Sende-Button</span>
                                        </div>
                                    </div>';
                                    
                }else{
                         
                    $form .= '<div class="card mt-2 createdFormField" id="field' . $formId . '">
                                <div class="card-body"> ' 
                                    . utf8_decode($formGroup) .
                                '</div>
                                <div class="card-footer ' . $fieldProperties[1][$key] . ' d-flex justify-content-between align-items-center">
                                    <span class="badge badge-pill type">'. $fieldProperties[0][$key] . '</span>

                                    <i class="fas fa-sort-up sortableIcons"></i>
                                    <i class="fas fa-sort-down sortableIcons"></i>
                            
                                    <button class="btn btn-danger deleteBtn" title="Löschen"><i class="fas fa-trash fa-xs"></i></button>
                                </div>
                            </div>';
                    

                    $formId++;          
                    
                }              
            }
        }
        
        return ["form" => $form, "submitButton" => $submitButton];
    }
    
    /**
     * Führt alle Prozesse zur Formularerstellung für den User und Besucher aus
     *
     * @param  array $post
     * @return void
     */

    public function saveForm(array $post, string $view){
        
        $user = false;
        $nameExists = false;

        $accountModal = new AccountModel();

        $formName = ucfirst(filter_var(trim($_POST["formName"]), FILTER_SANITIZE_STRING));
        $receiver = trim($_POST["reveiver"]);
        $htmlCodeOfForm = $_POST["form"];
        $action = $_POST["action"];
        $formId = isset($_POST["formId"]) ? (int) $_POST["formId"] : null;

        // Person ist ein User
        if(Session::getSession("userId")){
            $user = true;
            $userData = $this->getUserData($accountModal);
            $existingForms = $this->getAllForms();
           
            // Prüfen ob der Formularname bereits exisitert
            $nameExists = $this->checkIfFormNameAlreadyExist($existingForms, $formName);
        }

        if($user && $userData){
            $file = new File($userData->name, $formName, $htmlCodeOfForm, $user, $action); 
        }else{
            $file = new File("", $formName, $htmlCodeOfForm, $user, $action);
        }
        
        if($action == "create"){
            if($user){
                $insertResult = $this->executeInsert($formName, $receiver, $file, $userData, $user, $nameExists);   
                echo $insertResult;
            }else{
                echo $this->executeFormCreating($receiver, $file, $user);
            }
        }else{

           

            if(!empty($formId)){
                $actualForm = $this->getActualForm($formId);
                $oldFormName = $actualForm->name; 

                $updateResult = $this->executeUpdate($formName, $oldFormName, $receiver, $formId, $file, $userData, $user);  
                echo $updateResult;
            }
            
            
        }
        
        
    }

    /**
     * Updatet die Datenbankeinträge und Dateien des Formulars
     *
     * @param  string $formName
     * @param  string $oldFormName
     * @param  string $receiver
     * @param  int $formId
     * @param  object $file
     * @param  object $userData
     * @param  bool $user
     * @return string
     */

    private function executeUpdate(string $formName, string $oldFormName, string $receiver, int $formId, object $file, object $userData, bool $user) : string{
          
        if($file->updateFormFiles($user, $receiver, $formName, $oldFormName)){
                     
            $fileData = $this->getDataForDatabaseActions($file);
                
            if($this->model->updateForm($userData->userId, $formId, $formName, $receiver, $fileData["html"], $fileData["php"], $fileData["downloadLink"])){
                return "updated";
            }else{
                return "error";
            }
            
        }else{
            return "error";
        }      
        
    }
    
    /**
     * Fügt die Formulardaten in die Datenbank ein und erstellt die Scripte sowie die ZIP-Datei: Für eingeloggte User
     *
     * @param  string $formName
     * @param  string $receiver
     * @param  object $file
     * @param  object $userData
     * @param  bool $user
     * @param  bool $nameExists
     * @return string
     */

    private function executeInsert(string $formName, string $receiver, object $file, object $userData, bool $user, bool $nameExists) : string{
            
        if(!$nameExists){
            
            if($file->generateFormFiles($user, $receiver)){
                    
                $fileData = $this->getDataForDatabaseActions($file);
                    
                if($this->model->insertForm($userData->userId, $formName, $receiver, $fileData["html"], $fileData["php"], $fileData["downloadLink"])){
                    return "created";
                }else{
                    return "error";
                }
                        
                
            }else{
                return "error";
            }
        }else{
            return "nameAlreadyExist";
        }      
    
    }
    
    /**
     * Erstellt die ZIP-Datei mit den jeweilig generierten Formularscripten: Für Besucher
     *
     * @param  string $receiver
     * @param  object $file
     * @param  bool $user
     * @return void
     */
    
    private function executeFormCreating(string $receiver, object $file, bool $user){

        $formData =  $file->createFormForVisitor($user, $receiver);
       
        if($formData["action"]){
            return json_encode(
                    array($formData["downloadLink"])
                );
            
        }else{
            return "error";
        }
           
    }
    
    /**
     * Gibt alle Formulare des jeweiligen Users zurück
     *
     * @return array
     */
    
    private function getAllForms() : array{
        return $this->model->getAllForms(Session::getSession("userId"));
    }

    /**
     * Gibt ein Formular des jeweiligen Users zurück
     *
     * @param  int $formId
     * @return array
     */
    
    private function getActualForm(int $formId) : object{
        return $this->model->getForm(Session::getSession("userId"), $formId);
    }
    
    /**
     * Gibt die Daten des jeweiligen Users zurück
     *
     * @param  object $accountModal
     * @return object
     */

    private function getUserData(object $accountModal) : object{
        return $accountModal->getUserById(Session::getSession("userId"));
    }
    
    /**
     * Prüft, ob der gewählte Formularname beim jeweiligen User bereits existiert
     *
     * @param  array $existingForms
     * @param  string $formName
     * @return bool
     */
    
    private function checkIfFormNameAlreadyExist(array $existingForms, string $formName) : bool{
        

        if(count($existingForms) > 0){

            $nameExist = true;
            
            foreach($existingForms as $form){
                
                if($form->name == $formName){
                    return true;
                    break;
                }else{
                    $nameExist = false;
                }
            }

            return $nameExist;
        }

        return false;
    }
    
    /**
     * Gibt den HTML- & PHP-Code sowie Downloadlink des erstellen Formulars zurück
     *
     * @param  object $file
     * @return array
     */

    private function getDataForDatabaseActions(object $file) : array{
        $html = $file->getHTMLCodeForApi();
        $php = $file->getPHPCode();
        $downloadLink = $file->getZipPath();

        return ["html" => $html, "php" => $php, "downloadLink" => $downloadLink];
    }
    
    /**
     * Löscht das Formular des Users aus der Datenbank und seinem Benutzerordner
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */
    
    public function delete(array $post, string $view){
        $formId = isset($_POST["formId"]) ? (int) $_POST["formId"] : null;
        $actualForm = $this->getActualForm($formId);
        
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/project/generatedFormFiles/" . Session::getSession("username") . "/$actualForm->name/";
      
        if(!empty($formId)){
            if(File::deleteDir($dir)){
                if($this->model->deleteForm(Session::getSession("userId"), $formId)){
                    header("Location: /project/home?form=deleted");
                    exit;
                }
            }
        }

    }

   
}