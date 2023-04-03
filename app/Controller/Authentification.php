<?php

namespace App\Controller;

use App\Controller\Account\Account as Account;
use App\Controller\Api\Api as Api;
use App\Model\Account\Account as AccountModel;
use App\Model\Api\Api as ApiModel;
use App\Controller\Email as Email;
use App\Core\Session as Session;

/**
 * Übernimmt alle Authentifizierungsfunktionen:
 * - Login
 * - Registrierung
 * - Prüfung ob der Seitebesucher verifiziert ist die geschützen Routes aufzurufen
 * - User-Verifizierung
 * - API-Verifizierung
 * 
 * */

class Authentification{

    private $name;
    private $email;
    private $password;
    private $passwordRepeat;

    private $accountModel;
    private $apiModel;
    private $mailer;

    public $data = [];
    
    /**
     * Instanziiert das Model des Accounts sowie der Api und die E-Mail-Klasse
     *
     * @return void
     */
    
    public function __construct(){
        $this->accountModel = new AccountModel();
        $this->apiModel = new ApiModel();
        $this->mailer = new Email();
    }
    
    /**
     * Prüft, ob die Registration des neuen Users erfolgreich oder erfolglos war & gibt die Meldungen an die View weiter
     * 
     * > Wenn diese erfolgreich war, wird er in die Datenbanktabelle user eingetragen, es wird ihm eine Verifizierungsemail zugesendet und es wird eine Erfolgsmeldung erzeugt
     * > Wenn diese erfolglos war, werden Fehlermeldungen erzeugt
     * 
     * @param  array $post
     * @param  string $view
     * @return void
     */
    
    public function register(array $post, string $view){

        $name = ucfirst(filter_var(trim($post["name"]), FILTER_SANITIZE_STRING)) ?? "";
        $email = filter_var(trim($post["email"]), FILTER_VALIDATE_EMAIL) ?? "";
        $password = filter_var($post["password"]) ?? "";
        $passwordRepeat = filter_var($post["passwordRepeat"]) ?? "";
        
        if($this->checkRegistrationForm($name, $email, $password, $passwordRepeat)){
            $password = $this->hashPassword($password);
            $verifyHash = $this->generateVerifyHash($name, $password);
            
            if($this->accountModel->insertUser($name, $email, $password, $verifyHash, 0)){

                $user = $this->accountModel->getUserByName($name);
                $userId = $user->userId;
                
                if($this->mailer->sendVerificationEmailForRegistry($name, $email, $userId, $verifyHash)){
                    $this->data["success"] = "<p class='text-success text-center mt-3'>Deine Registrierung ist erfolgreich. Wir haben dir eine Verifizierungesemail zugesendet. Bitte verifiziere dich jetzt darüber, um Zugriff zu unserem Portal zu bekommen.</p>";
                }else{
                    $this->data["error"] = "<p class='text-danger text-center mt-3'>Ein Fehler ist passiert. Bitte melde dich an test@example.com!</p>";
                }
                
            }else{
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Ein Fehler ist passiert. Bitte melde dich an test@example.com!</p>";
            }        
            
        }
        
        $this->data["path"] = "./";
        $class = new Account();
        $class->refresh($view, $this->data);       
       
    }
    
    /**
     * Prüft ob der Login des Users erfolgreich oder erfolglos war
     *
     * > Wenn dieser erfolgreich war, werden einige Userdaten zu ihm aus der Datenbank ausgelesen, mit diesen Daten werden zwei Sessions erstellt, die den User dazu verifizieren auf den Mitgliederbereich zuzugreifen, 
     * und der User wird in seinen Mitgliederbereich weitergeleitet
     * > Wenn dieser erfolglos war, wird die View mit den Fehlermeldungen geladen
     * 
     * @param  array $post
     * @param  string $view
     * @return void
     */
    
    public function login(array $post, string $view){
        $data = filter_var(trim($post["nameOrEmail"])) ?? "";
        $password = filter_var($post["password"]) ?? "";

        if($this->checkLoginForm($data, $password)){

            if(filter_var($data, FILTER_VALIDATE_EMAIL)){
                $data = $this->accountModel->getUserByEmail($data);
            }else{
                $data  = $this->accountModel->getUserByName(ucfirst($data));
            }
            
            Session::setSession("username", $data->name);
            Session::setSession("userId", $data->userId);

            header("Location: /project/home");
            exit;
        }
        
        $this->data["path"] = "./";
        $class = new Account();
        $class->refresh($view, $this->data);
      
    }
    
    /**
     *  Verifiziert die Echtheit des User 
     *
     * > Wenn die Verifizierung erfolgreich ist, wird sein Zugriff auf sein Account aktiviert 
     * > Wenn die Verifizierung erfolglos ist, wird die View mit den Fehlermeldungen geladen
     * 
     * @param  array $get
     * @param  string $view
     * @return void
     */

    public function verifyUser(array $get, string $view){

        $userId = isset($_GET["id"]) ? filter_var(trim($_GET["id"]), FILTER_VALIDATE_INT) : 0;
        $verifyHash = isset($_GET["verifyHash"]) ? trim($_GET["verifyHash"]) : "";

        if($this->checkVerifyHash($userId, $verifyHash)){
            if($this->accountModel->updateAccess($userId)){
                $this->data["success"] = "<p class='text-success text-center mt-3'>Deine Verifizierung ist abgeschlossen.</p> <a href='/project/login' class='btn btn-success form-control'>Zum Login</a>";
            }else{
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Es ist ein Fehler bei deiner Verifizierung aufgetreten!</p>";
            }
        }

        $this->data["path"] = "./";
        $class = new Account();
        $class->index($view, $this->data);
          
    }
    
    /**
     * Prüft ob der Verifyhash aus der URL mit dem Verifyhash des Users in der Datenbank übereinstimmt
     *
     * @param  int $userId
     * @param  string $verifyHash
     * @return bool
     */

    private function checkVerifyHash(int $userId, string $verifyHash) : bool{

        $data = $this->accountModel->getVerifyHash($userId);
        
        if(count(get_object_vars($data)) > 0){
            if(!hash_equals($verifyHash, $data->verifyHash)){
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Verifizierung nicht möglich: Falscher Verifizierungscode!</p>";
                return false;
            }
        }else{
            $this->data["error"] = "<p class='text-danger text-center mt-3'>Verifizierung nicht möglich</p>";
                return false;
        }
        

        return true;
    }
    
    /**
     * Prüft die Eingaben des Login-Formulars
     *
     * @param  string $data
     * @param  string $password
     * @return bool
     */

    private function checkLoginForm(string $data, string $password) : bool{
        
        if(empty($data) || empty($password)){
            $this->data["error"] = "<p class='text-danger text-center mt-3'>Bitte fülle alle Felder aus!</p>";
            return false;
        }else{

            if(filter_var($data, FILTER_VALIDATE_EMAIL)){
                $user = $this->accountModel->getUserByEmail($data);
            }else{
                $user = $this->accountModel->getUserByName(ucfirst($data));
            }

            $password = Authentification::generateSecurePassword($password);

            if(count(get_object_vars($user)) === 0){
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Name, Email oder Passwort stimmen nicht überein!</p>";
                return false;
            }else{

                if(!password_verify($password, $user->password)){
                    $this->data["error"] = "<p class='text-danger text-center mt-3'>Name, Email oder Passwort stimmen nicht überein!</p>";
                    return false;
                }else if($user->verified != 1){
                    $this->data["error"] = "<p class='text-danger text-center mt-3'>Dein Account wurde noch nicht verifiziert! Bitte verifiziere diesen!</p>";
                    return false;
                }
            }        
        }

        return true;
    }
    
    /**
     * Prüft die Eingaben des Registrationsformulars
     *
     * @param  string $name
     * @param  string $email
     * @param  string $password
     * @param  string $passwordRepeat
     * @return bool
     */

    private function checkRegistrationForm(string $name, string $email, string $password, string $passwordRepeat) : bool{

        if(empty($name) || empty($email) || empty($password) || empty($passwordRepeat)){
            $this->data["error"] = "<p class='text-danger text-center mt-3'>Bitte fülle alle Felder aus!</p>";
            return false;
        }else if(strlen($name) < 3){
            $this->data["error"] = "<p class='text-danger text-center mt-3'>Dein Name muss mindestens 3 Buchstaben lang sein!</p>"; 
            return false;  
        }else if(strlen($password) < 4){
            $this->data["error"] = "<p class='text-danger text-center mt-3'>Dein Passwort muss mindestens 4 Zeichen lang sein!</p>"; 
            return false;  
        }else{

            $userByName = $this->accountModel->getUserByName($name);
            $userByEmail = $this->accountModel->getUserByEmail($email);

            if($password !== $passwordRepeat){
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Die Passwörter stimmen nicht überein!</p>";
                return false;
            }else if(count(get_object_vars($userByName)) > 0){
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Dieser Name wird bereits verwendet! Bitte wähle einen anderen!</p>";
                return false;
            }else if(count(get_object_vars($userByEmail)) > 0){
                $this->data["error"] = "<p class='text-danger text-center mt-3'>Diese E-Mail wird bereits verwendet! Bitte nutze eine andere!</p>";
                return false;
            }

        } 

        return true;
    }
    
    /**
     * Erstellt aus dem Klartextpasswort ein Hash
     *
     * @param  string $password
     * @return string
     */

    private function hashPassword(string $password) : string {
        return password_hash(Authentification::generateSecurePassword($password), PASSWORD_DEFAULT);
    }
    
    /**
     * Generiert den Verifyhash des Users mit Hilfe seines Names, Passworts & eines Zusatzstrings
     *
     * @param  string $name
     * @param  string $password
     * @return string
     */

    private function generateVerifyHash(string $name, string $password) : string{
        $salt = "U/()=(/&%$";
        $value = $name . $password . $salt;

        return hash("sha256", $value);
    } 
    
     /**
     * Fügt dem gewählten Passwort des Users noch eine Zeichenkette hinzu, die das Passwort sicherer macht, und gibt dieses zurück 
     *
     * @param  string $password
     * @return void
     */
    public static function generateSecurePassword(string $password){
        $password .= "$(/#al98";

        return $password;
    }

    
    
    /**
     * Api-Zugriff wird erstellt
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */

    public function requestApiAccess(array $post, string $view){
        $apiCode = $this->generateAPICode();

        if($this->apiModel->insertNewAccess(Session::getSession("userId"), $apiCode)){
           header("Location: /project/api");
        }  
    }
    
    /**
     * Api-Schlüssel des Nutzers wird generiert
     *
     * @return void
     */
    
    private function generateAPICode(){
        $salt = "lk?äü+#k.-kla";
        $value = Session::getSession("username") . Session::getSession("userId") . $salt;

        return hash("sha512", $value);
    }

    /**
     * Authentifiziert den Nutzer für den API-Zugang zu seinen Formularen
     *
     * @param  array $post
     * @return bool|array
     */

    public function authentificateApiAccess(array $post){
        $name = isset($post["name"]) ? ucfirst($post["name"]) : null;
        $apiCode = isset($post["apiCode"]) ? $post["apiCode"] : null;
        $formName = isset($post["form"]) ? $post["form"] : null;

        if(empty($name) || empty($apiCode) || empty($formName)){
            return false;
        }else{
            $user = $this->accountModel->getUserByName($name);

            if(count(get_object_vars($user)) > 0){
                $userId = $user->userId;
                $apiCodeOfUser = $this->apiModel->getApiCodeOfUser($userId);

                if(!hash_equals($apiCodeOfUser->apiCode, $apiCode)){
                    return false;
                }else{
                    return ["userId" => $userId, "form" => $formName];
                }
            }else{
                return false;
            }
            
        }
    }

    /**
     * Prüft, ob der User den Mitgliederbereich nutzen darf. Falls nein wird ihm der Zugriff verwährt
     *
     * @param  string $view
     * @return void
     */
    
    public static function checkRestrictArea(string $view){
        
        $sessionExists = Session::sessionsExists();

        if( (!$sessionExists && $view !== "account/register") && (!$sessionExists && $view !== "account/login") && (!$sessionExists && $view !== "account/verify")){
            
            $data["path"] = "./";
            $data["css"] = "";
            $data["js"] = "";
            $data["header"] = "includes/header.php";
            $data["footer"] = "includes/footer.php";
                
            if(in_array($view, array("account/editName", "account/editEmail", "account/editPassword", "form/create", "form/edit"))){
                $data["path"] = "../";
                $data["header"] = "app/view/includes/header.php";
                $data["footer"] = "app/view/includes/footer.php";
            }
                
            $data["title"] = "Geschützer Bereich";
            $data["image"] = "/project/app/view/assets/img/restricted-area.jpg";
            $data["info"] = "Geschützter Bereich";
            $data["url"] = "/project/login";
            $data["btnText"] = "Zum Login";
                
            include "app/view/error.php";

            exit;
            
        }

    }
    
   
    
}