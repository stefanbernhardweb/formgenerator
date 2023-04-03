<?php

namespace App\Controller\Account;

use App\Core\Controller as Controller;
use App\Core\Session as Session;
use App\Controller\Authentification as Authentification;
use App\Controller\Form\File as File;

class Account extends Controller
{

    private $model = null;

    /**
     * Es erfolgt die Instanziierung des Account Models
     *
     * @return void
     */

    public function __construct()
    {
        $this->model = $this->loadModel("Account", "Account");
    }

    /**
     * Diese Funktion wird vom Router zur Anzeige der entsprechenden View ausgeführt. Dieser können Daten über das Array $data übergeben werden
     * Zusätzlich wird geprüft, ob der User auch die Rechte hat die angeforderten Seiten aufzurufen
     *
     * @param  string $view
     * @param  array $data
     * @return void
     */

    public function index(string $view, array $data = [])
    {

        if ($view) {

            $view = substr($view, 1, -4);

            Authentification::checkRestrictArea($view);

            if (!isset($data["success"])) {
                $data["success"] = null;
            }

            if (!isset($data["error"])) {
                $data["error"] = null;
            }

            // Eigene CSS- & JavaScript Dateien für diese Route
            $data["css"] = '';
            $data["js"] = '';

            // Zur Einbindung der einzelnen 3rd-Party Bibliotheken aus dem Vendor Ordner
            $data["path"] = "./";
            $data["nav-link-text"] = "Zurück";

            switch ($view) {
                case "account/register":
                    $data["title"] = "Registrieren";
                    $data['navLink'] = "./";

                    $this->loadView($view, $data);
                    break;
                case "account/login":
                    $data["title"] = "Login";
                    $data['navLink'] = "./";

                    $this->loadView($view, $data);
                    break;
                case "account/verify":
                    $data["title"] = "Verifizierung";

                    $this->loadView($view, $data);
                    break;
                case "account/account":
                    $data["title"] = "Account";
                    $data["activeHome"] = "";
                    $data["activeAccount"] = "active";
                    $data["activeApi"] = "";

                    $userData = $this->getUserData(Session::getSession("userId"));

                    $data["id"] = $userData->userId;
                    $data["username"] = $userData->name;
                    $data["email"] = $userData->email;

                    $this->loadView($view, $data);
                    break;
                case "account/editName":
                    $data["title"] = "Username ändern";
                    $data["path"] = "../";
                    $data['navLink'] = "/project/account";

                    $this->loadView($view, $data);
                    break;
                case "account/editEmail":
                    $data["title"] = "E-Mail-Adresse ändern";
                    $data["path"] = "../";
                    $data['navLink'] = "/project/account";

                    $this->loadView($view, $data);
                    break;
                case "account/editPassword":
                    $data["title"] = "Passwort ändern";
                    $data["path"] = "../";
                    $data['navLink'] = "/project/account";

                    $this->loadView($view, $data);
                    break;
            }
        }
    }

    /**
     * Gibt Daten des Users für sein Account zurück
     *
     * @param  int $id
     * @return object
     */

    public function getUserData(int $id): object
    {
        return $this->model->getUserById($id);
    }

    /**
     * Ladet die bereits geladene View neu
     *
     * @param  string $view
     * @param  array $data
     * @return void
     */

    public function refresh(string $view, array $data = [])
    {

        if ($view) {

            $view = substr($view, 1, -4);

            $data["css"] = '';
            $data["js"] = '';

            $data["path"] = "./";
            $data["nav-link-text"] = "Zurück";

            switch ($view) {
                case "account/register":
                    $data["title"] = "Registrieren";
                    $data['navLink'] = "./";
                    $this->loadView($view, $data);
                    break;
                case "account/login":
                    $data["title"] = "Login";
                    $data['navLink'] = "./";
                    $this->loadView($view, $data);
                    break;
                case "account/editName":
                    $data["title"] = "Name ändern";
                    $data["path"] = "../";
                    $data['navLink'] = "/project/account";
                    $this->loadView($view, $data);
                    break;
                case "account/editEmail":
                    $data["title"] = "E-Mail ändern";
                    $data["path"] = "../";
                    $data['navLink'] = "/project/account";
                    $this->loadView($view, $data);
                    break;
                case "account/editPassword":
                    $data["title"] = "Passwort ändern";
                    $data["path"] = "../";
                    $data['navLink'] = "/project/account";
                    $this->loadView($view, $data);
                    break;
            }
        }
    }

    /**
     * Wird ausgeführt, wenn der User seinen Namen ändern möchte. Prüft die Formulareingabe
     * 
     * Ist die Prüfung erfolgreich wird der Name des Users geupdatet und eine Erfolgsmeldung erzeugt, welche an die View übergeben wird
     * Ist die Prüfung erfolglos wird eine Fehlermeldung erzeugt, welche an die View übergeben wird
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */

    public function editName(array $post, string $view)
    {
        $data = [];
        /*
        $name = ucfirst(filter_var(trim($post["name"]), FILTER_SANITIZE_STRING)) ?? "";


        $user = $this->model->getUserByName($name);

        if (empty($name)) {
            $data["error"] = "<p class='text-danger text-center mt-3'>Bitte gebe deinen neuen Namen ein!</p>";
        } else if (strlen($name) < 3) {
            $data["error"] = "<p class='text-danger text-center mt-3'>Dein Name muss mindestens 3 Buchstaben lang sein!</p>";
        } else if (count(get_object_vars($user)) > 0) {
            $data["error"] = "<p class='text-danger text-center mt-3'>Diesen Namen gibt es bereits! Bitte wähle einen anderen!</p>";
        } else {

            $oldName = Session::getSession("username");

            if (File::renameUserFormFolder($name, $oldName)) {

                if ($this->model->updateName(Session::getSession("userId"), $name)) {
                    $data["success"] = "<p class='text-success text-center mt-3'>Dein Name wurde erfolgreich geändert!</p>";
                    Session::setSession("username", $name);
                } else {
                    $data["error"] = "<p class='text-danger text-center mt-3'>Es ist ein Fehler aufgetreten! Bitte wende dich an stefan@exmaple.de</p>";
                }
            } else {
                $data["error"] = "<p class='text-danger text-center mt-3'>Es ist ein Fehler aufgetreten! Bitte wende dich an stefan@exmaple.de</p>";
            }
        }*/

        $data["error"] = "<p class='text-danger text-center mt-3'>Die Änderung des Namens ist deaktiviert.</p>";
        $data["path"] = "../";
        $this->refresh($view, $data);
    }

    /**
     * Wird ausgeführt, wenn der User seine E-Mail ändern möchte. Prüft die Formulareingabe
     * 
     * Ist die Prüfung erfolgreich wird die E-Mail des Users geupdatet und eine Erfolgsmeldung erzeugt, welche an die View übergeben wird
     * Ist die Prüfung erfolglos wird eine Fehlermeldung erzeugt, welche an die View übergeben wird
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */

    public function editEmail(array $post, string $view)
    {

        $data = [];

        $email = filter_var(trim($post["email"]), FILTER_VALIDATE_EMAIL) ?? "";

        if (empty($email)) {
            $data["error"] = "<p class='text-danger text-center mt-3'>Bitte gebe deine neue E-Mail-Adresse ein!</p>";
        } else {

            $user = $this->model->getUserByEmail($email);

            if (count(get_object_vars($user)) > 0) {
                $data["error"] = "<p class='text-danger text-center mt-3'>Diese E-Mail wird bereits verwendet! Bitte nutze eine andere!</p>";
            } else if ($this->model->updateEmail(Session::getSession("userId"), $email)) {
                $data["success"] = "<p class='text-success text-center mt-3'>Deine E-Mail-Adresse wurde erfolgreich geändert!</p>";
            }
        }

        $data["path"] = "../";
        $this->refresh($view, $data);
    }

    /**
     * Wird ausgeführt, wenn der User seine Passwort ändern möchte. Prüft die Formulareingabe
     * 
     * Ist die Prüfung erfolgreich wird das Passwort des Users geupdatet und eine Erfolgsmeldung erzeugt, welche an die View übergeben wird
     * Ist die Prüfung erfolglos wird eine Fehlermeldung erzeugt, welche an die View übergeben wird
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */

    public function editPassword(array $post, string $view)
    {

        $data = [];

        $password = $post["password"] ?? "";
        $passwordRepeat = $post["passwordRepeat"] ?? "";
        /*
        if(empty($password) || empty($passwordRepeat)){
            $data["error"] = "<p class='text-danger text-center mt-3'>Bitte fülle alle Felder aus!</p>";      
        }else if(strlen($password) < 4){
            $data["error"] = "<p class='text-danger text-center mt-3'>Dein Passwort muss mindestens 4 Zeichen lang sein!</p>";   
        }else if($password !== $passwordRepeat){
            $data["error"] = "<p class='text-danger text-center mt-3'>Die Passwörter stimmen nicht überein!</p>";   
        }else{
            $password = Authentification::generateSecurePassword($password);
            $password = password_hash($password, PASSWORD_DEFAULT);

            if($this->model->updatePassword(Session::getSession("userId"), $password)){
                $data["success"] = "<p class='text-success text-center mt-3'>Dein Passwort wurde erfolgreich geändert!</p>";
            }
            
        } */

        $data["error"] = "<p class='text-danger text-center mt-3'>Die Passwortänderung ist deaktiviert.</p>";

        $data["path"] = "../";
        $this->refresh($view, $data);
    }

    /**
     * Löscht alle vorhandenen Sessions und leitet des User auf die Startseite um
     *
     * @param  string $view
     * @return void
     */

    public function logout()
    {
        Session::destroySession();

        header("Location: /project/");
        exit;
    }

    /**
     * Löscht den Account des Users und leitet ihn auf die Startseite um.
     *
     * @param  array $post
     * @param  string $view
     * @return void
     */

    public function delete(array $post, string $view)
    {
        $id = filter_var($post["id"], FILTER_VALIDATE_INT) ?? "";

        if (!empty($id)) {

            if ($id == Session::getSession("userId")) {

                $dir = $_SERVER['DOCUMENT_ROOT'] . "/project/generatedFormFiles/" . Session::getSession("username") . "/";

                if (File::deleteDir($dir)) {
                    if ($this->model->deleteUser($id)) {
                        $data["success"] = "<div class='alert alert-success mb-3 mx-auto w-50'>
                                                <p class='text-center m-0'>Dein Account wurde erfolgreich gelöscht</p>
                                            </div>";

                        Session::destroySession();

                        $data["title"] = "Start";
                        $data["path"] = "./";
                        $data["css"] = "";
                        $data["js"] = "";

                        $this->loadView($view, $data);
                    }
                }
            } else {

                $this->index("/account/account.php");
            }
        }
    }
}
