<?php

/**
 * Fehlende Permissions auf dem Linux Webserver fürs erstellen von den HTML- & PHP-Scripten sowie der ZIP-Datei
 */


use App\Core\Router as Router;

require_once "autoload.php";


$router = new Router();


 /** Routes zur Anzeige der View */

 //$router->setRoute(route, view, destination, http-method);

// Startseite & Error
$router->setRoute("/", "/index.php", "", "GET");
$router->setRoute("/error", "/error.php", "", "GET");

// Account
$router->setRoute("/register", "/account/register.php", "Account@index", "GET");
$router->setRoute("/login", "/account/login.php", "Account@index", "GET");
$router->setRoute("/logout", "index", "Account@logout", "GET");

$router->setRoute("/account", "/account/account.php", "Account@index", "GET");
$router->setRoute("/account/edit-name", "/account/editName.php", "Account@index", "GET");
$router->setRoute("/account/edit-email", "/account/editEmail.php", "Account@index", "GET");
$router->setRoute("/account/edit-password", "/account/editPassword.php", "Account@index", "GET");

/** Account: Bearbeitung und Löschen */
$router->setRoute("/account", "index", "Account@delete", "POST");
$router->setRoute("/account/edit-name", "/account/editName.php", "Account@editName", "POST");
$router->setRoute("/account/edit-email", "/account/editEmail.php", "Account@editEmail", "POST");
$router->setRoute("/account/edit-password", "/account/editPassword.php", "Account@editPassword", "POST");

// Formulargenerator
$router->setRoute("/form/create", "/form/create.php", "Form@index", "GET");
$router->setRoute("/form/edit", "/form/edit.php", "Form@index", "GET");

/** Formulargenerator: Formular erstellen & speichern, bearbeiten und löschen */
$router->setRoute("/form/create", "/area/home.php", "Form@saveForm", "POST");
$router->setRoute("/form/edit", "/form/edit.php", "Form@getForm", "POST");
$router->setRoute("/form/update", "/area/home.php", "Form@saveForm", "POST");
$router->setRoute("/form/delete", "/area/home.php", "Form@delete", "POST");
$router->setRoute("/form/deleteVisitorData", "", "File@deleteVisitorsData", "GET");

// Informationsseiten
$router->setRoute("/impressum", "/information/impressum.php", "Information@index", "GET");
$router->setRoute("/datenschutz", "/information/datenschutz.php", "Information@index", "GET");

// Mitgliederbereich: Home
$router->setRoute("/home", "/area/home.php", "Area@index", "GET");

// API
$router->setRoute("/api", "/api/start.php", "Api@index", "GET");
$router->setRoute("/api", "/api/start.php", "Authentification@requestApiAccess", "POST");
$router->setRoute("/api/getForm", "/api/verify.php", "Api@getFormOverApi", "POST");

/** Routes für die Authentifizierung des Users */
$router->setRoute("/register", "/account/register.php", "Authentification@register", "POST");
$router->setRoute("/login", "/account/login.php", "Authentification@login", "POST");
$router->setRoute("/verify", "/account/verify.php", "Authentification@verifyUser", "GET");



$urlRoute = substr($_SERVER["REQUEST_URI"], 9);



/**
 * Führt die Route aus 
 * 
 * */ 

if(!empty($urlRoute)){
    $router->executeRoute("/" . $urlRoute);
}else{
    $router->loadStartPage();
}



