<?php

namespace App\Core;

use App\Core\Session as Session;

/**
 * 
 * Diese Klasse ist für das URL-Routing und das entsprechende Laden der richtigen Controller & Funktionen zuständig
 * 
 */

class Router{

    private $routes = [];
    private $actualRoute;

    /**
     * Speichert die Route in den Routes-Array
     *
     * @param  string $route
     * @param  string $view
     * @param  string $destination
     * 
     * @return void
     */

    public function setRoute(string $route, string $view, string $destination, string $method){

        if("" !== $destination){
            $destination = explode("@", $destination);

            $this->routes[] = [
                $route => [
                    "view" => $view,
                    "controller" => $destination[0],
                    "function" => $destination[1],
                    "method" => strtolower($method)
                ]   
            ];
        }else{
            $this->routes[] = [
                $route => [
                    "route" => $route,
                    "view" => $view,
                    "controller" => null,
                    "function" => null,
                    "method" => strtolower($method)  
                ]   
            ];
        }      
    }
     
    
    
    /**
     * Führt die Aktion der einzelnen Controller, die hinter der Route stecken, aus
     *
     * @param  string $actualRoute
     * @return void
     */

    public function executeRoute(string $actualRoute){
       
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $routeExists = false;
        
        foreach($this->routes as $route){

            /** Route mit dynamischen GET-Parameter */
            $routeWithParam = explode("?", $actualRoute);
            if(count($routeWithParam) > 1){
                $actualRoute = $routeWithParam[0];          
            }

            if(isset($route[$actualRoute]) && $route[$actualRoute]["method"] == $method){

                $routeExists = true;
                  
                $this->actualRoute = $route;
                $this->redirectUserIfLoggedIn();

                $controller = $route[$actualRoute]["controller"];      
                $function = $route[$actualRoute]["function"];              
                
                /** Routing: HTTP POST*/ 
                
                if("post" == $method){        
                    
                    if($function === "register" || $function === "login" || $function === "requestApiAccess"){                
                        $controller = "App\Controller\\$controller";           
                        $class = new $controller();

                        $class->$function($_POST, $route[$actualRoute]["view"]);

                    }else if(in_array($function, array("editName", "editEmail", "editPassword", "delete", "saveForm", "getForm", "getFormOverApi"))){
                        
                        $controller = "App\Controller\\$controller\\$controller";           
                        $class = new $controller();

                        $class->$function($_POST, $route[$actualRoute]["view"]);
                    }
                }else{

                     /** Routing: HTTP GET */

                    if($function === "index" || $function === "logout" || $function === "deleteVisitorsData"){
                        
                        if($function === "deleteVisitorsData"){
                            $controller = "App\Controller\Form\\$controller";
                            $class = $controller::$function();
                        }else{
                            $controller = "App\Controller\\$controller\\$controller";
                            $class = new $controller();
                        }
                            
                        
                        
                        if($function === "index"){
                            if(count($_GET) > 0){
                                $class->$function($route[$actualRoute]["view"], $_GET);
                            }else{
                                $class->$function($route[$actualRoute]["view"]);
                            }
                            
                        }else if($function !== "deleteVisitorsData"){
                            $class->$function();
                        }
                       

                    }else if($function === "verifyUser" ){

                        $controller = "App\Controller\\$controller";
                        $class = new $controller();
                        
                        $class->$function($_GET, $route[$actualRoute]["view"]);

                    }
                }
            }
           
        } 

        
        // 404-Error
        $this->actualRoute = $actualRoute;
        $this->errorPage404($routeExists); 
        
     }

     /**
      * Lädt die Startseite & prüft, ob der User bereits eingeloggt ist. Wenn ja, wird der User auf die Startseite des Mitgliederbereiches umgeleitet
      *
      * @return void
      */

      public function loadStartPage(){
        
        $this->redirectUserIfLoggedIn();
       
        $data["title"] = "Start";
        $data["path"] = "./";
        $data["css"] = "";
        $data["js"] = "";
        $data["success"] = "";
        include "./app/view/index.php";

     }
     
     /**
      * Lädt die HTTP 404-Error Page, wenn die geladene Route nicht existiert
      *
      * @param  bool $routeExists
      * @return void
      */

     private function errorPage404(bool $routeExists){

        if(!$routeExists){

            $data["path"] = "./";

            if(count(explode("/", $this->actualRoute)) > 2){
                $data["path"] = "../";
            }

            $data["css"] = "";
            $data["js"] = "";
            
            $data["header"] = "includes/header.php";
            $data["footer"] = "includes/footer.php";
            $data["title"] = "Seite wurde nicht gefunden - 404 Error";
            $data["image"] = "/project/app/view/assets/img/404-error.jpg";
            $data["info"] = "Seite wurde nicht gefunden";
            $data["url"] = "/project/";
            $data["btnText"] = "Zurück zur Startseite";
            include "app/view/error.php";
            exit;
        }

     }
 
     /**
      * Leitet den User, wenn er eingeloggt ist, automatisch beim Aufruf der Startseite (./), des Logins (/login) und der Registration (/register) 
      * auf die Startseite des Mitgliederbereichs um  
      *
      * @return void
      */

      
    private function redirectUserIfLoggedIn(){
         
        $sessionExists = Session::sessionsExists();
        
        if(!empty($this->actualRoute)){
            // Umleitung von den Seiten Login & Registration
            if(in_array(array_keys($this->actualRoute)[0], array("/login", "/register")) && $sessionExists){
                header("Location: /project/home");
                exit;
            }
        }else{
            // Umleitung von der Startseite
            if($sessionExists){
                header("Location: /project/home");
                exit;
            }    
        }

    }

    
}
       

            
            
            
    
