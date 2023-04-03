<?php

namespace App\Controller\Form;

use ZipArchive;
use DomDocument;
use DomXPath;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Datetime;

class File{

    private $path;
    private $pathToFiles;
    private $pathToZips;
    private $downloadPath;
    private $html;
    private $htmlForApi;
    private $php;
    private $installation;

    // TODO: UML-Diagramm erweitern
    
    
    /**
     * Legt die Pfade fest, löscht beim Formularupdate den Formularordner und den HTML-Code in das Attribut html ab
     *
     * @param  string $userName
     * @param  string $formName
     * @param  string $html
     * @param  bool $user
     * @param  string $action
     * @return void
     */
    

    public function __construct(string $userName, string $formName , string $html, bool $user, string $action){
       
        $this->html = $html;

        $userPath = $_SERVER["DOCUMENT_ROOT"] . "/project/generatedFormFiles/$userName";
        $downloadPathUser = "/project/generatedFormFiles/$userName";

        $visitorPath = $_SERVER["DOCUMENT_ROOT"] . "/project/generatedFormFiles/visitor";
        $downloadPathVisitor = "/project/generatedFormFiles/visitor";
        
        if($user){

            if($action === "create"){
                if(file_exists("$userPath/$formName/")){
                    echo "nameAlreadyExist";
                    exit;
                } 
            }

            $this->path = $userPath;
            $this->pathToFiles = "$userPath/$formName/files/";
            $this->pathToZips = "$userPath/$formName/zip/"; 
            $this->downloadPath = "$downloadPathUser/$formName/zip/";
            
        }else{
            
            if(file_exists("$visitorPath/$formName/")){
                $id = 1;

                do{
                    $newFormName = $formName . $id;
                    $id++;
                    $this->pathToZips = "$visitorPath/$newFormName/zip/";
                    $this->downloadPath = "$downloadPathVisitor/$newFormName/zip/";
                }while(file_exists("$visitorPath/$newFormName"));

            }else{
                $this->pathToZips = "$visitorPath/$formName/zip/";
                $this->downloadPath = "$downloadPathVisitor/$formName/zip/";
            }
            
            
        }
        
    }

      
    /**
     * Erstellt die Installations-Datei mit dem festgelegten Text
     *
     * @param  string $receiver
     * @return void
     */
    

    private function generateInstallationFile(string $receiver){
        $this->setInstallationText($receiver);
        file_put_contents($this->pathToFiles . "/installation.txt", $this->installation);
    }

     /**
     * Legt die Installations-Anleitung fest
     *
     * @param  string $receiver
     * @return void
     */
    
    private function setInstallationText($receiver){

        if(!empty($receiver)){
            $this->installation = '
Das Formular basiert auf Bootstrap und dem PHP-Mailer, mit dem der E-Mail Versand stattfinden wird. Damit das Formular auch funktioniert, musst du diese zwei Komponenten in deine Webseite integrieren. 
Gehe dazu wie in der Installationsanleitung beschrieben vor.

Installationsanleitung:
1. Binde Bootstrap in deine Webseite ein.Hierzu findest du unter https://getbootstrap.com/docs/5.1/getting-started/introduction/ eine Anleitung, die dir Schritt für Schritt zeigt, wie du Bootstrap in deine Webseite integrieren kannst.
2. Downloade dir den PHP-Mailer unter https://github.com/PHPMailer/PHPMailer/archive/master.zip, benenne den Ordner in deinen gewünschten Namen um und lade diesen auf deinen FTP-Server hoch. 
Für das Hochladen des Ordners auf den FTP-Server findest du hier eine gute Übersicht und weitere Anleitungen: https://www.html-seminar.de/online-stellen.htm
3. Nachdem du nun den Ordner erfolgreich hochgeladen hast, musst du im Script form-php.php noch folgende Änderungen vornehmen:
    3.1: Ändere die Pfade zu den Dateien des PHP-Mailers. Nuzte dort deinen Pfad, der direkt zu dem PHP-Mailer führt.
    3.2: Lege unter $mailer->setFrom den Absender der E-Mail, mit Name und E-Mail Adresse, fest
    3.3: Lege unter $mailer->Subject deinen Wunschbetreff fest.
    3.4: Ersetzte die E-Mail-Adresse test@example.de mit der E-Mail Adresse, unter die sich deine Besucher bei einem Fehler melden können
4. Integriere den HTML- & PHP-Code deines Formulars in deine Webseite
            
Nun hast du alle Installationsschritte erfolgreich ausgeführt und kannst dein Formular in deiner Webseite nutzen. :)';    
        }else{
            $this->installation = '
Das Formular basiert auf Bootstrap. Damit das Formular richtig dargestellt wird, musst du Bootstrap in deine Webseite integrieren. 
Gehe dazu wie in der Installationsanleitung beschrieben vor.

Installationsanleitung:
1. Binde Bootstrap in deine Webseite ein. Hierzu findest du unter https://getbootstrap.com/docs/5.1/getting-started/introduction/ eine Anleitung, die dir Schritt für Schritt zeigt, wie du Bootstrap in deine Webseite integrieren kannst.
2. Integriere den HTML- & PHP-Code deines Formulars in deine Webseite

Nun hast du alle Installationsschritte erfolgreich ausgeführt und kannst dein Formular in deiner Webseite nutzen. :)';    
        }
        

    }
    /**
     * Erstellt die HTML-Datei mit dem zusammengebauten HTML-Code
     *
     * @return void
     */

    private function generateHTMLFile(){
        $this->setHTMLCode();
        file_put_contents($this->pathToFiles . "/form-html.php", $this->html);
    } 
    
    /**
     * Baut den HTML-Code zusammen und weist diesen dem Attribut html zu
     *
     * @return void
     */

    private function setHTMLCode(){
        $require = "<?php 
            require('form-php.php');
        ?>
        ";

        $output = '<?php echo $error ?? $success; ?>';

        // HTML-Code für die API
        $this->htmlForApi =  "<div class='container'>
                                " . $this->html . "    
                            </div>";

        // HTML-Code für die Dateien
        $this->html = "<div class='container'>
                            " . $this->html . "
                            " . $output . "
                        </div>";
                        
        

        $this->html = $require . $this->html;
        
    }

     /**
     * Erstellt die PHP-Datei mit dem zusammengebauten PHP-Code
     *
     * @param  string $receiver
     * @return void
     */

    private function generatePHPFile(string $receiver){
        $this->setPHPCode(true, $receiver);  
        file_put_contents($this->pathToFiles . "form-php.php", $this->php);
    }

    /**
     * Führt alle PHP-Code-Erstellungsfunktionen aus und weist den generierten PHP-Code dem Attribut php zu
     *
     * @param  string $receiver
     * @return void
     */

    private function setPHPCode(bool $user = true, string $receiver){
        $dom = new DOMDocument();

        if($user){
            $dom->loadHTMLFile($this->pathToFiles . "form-html.php");
        }else{
            $dom->loadHTML($this->html);
        }
        
        $fieldData = $this->getAllFieldData($dom);
        $requiredFields = $this->getRequiredFieldNames($dom);

        $this->php = $this->buildPHPCodeTogether($fieldData, $requiredFields, $receiver);
    }
    
    
    /**
     * Geht das ganze DOM des HTML-Formulars durch und liefert als Rückgabewert die Werte der Name-Attribute der einzelnen Felder
     *
     * @param  object $dom
     * @return array
     */
    private function getAllFieldData(object $dom) : array{
        
        $domXPath = new DomXPath($dom);
        $submitButton = "";
        $allFurtherFields = [];

        // Erfasse alle Elemente die ein name-Attribut besitzen (dieses sind nur Formularfelder)
        $fields = $domXPath->query("//*/@name");
        
        foreach($fields as $field){

            if(substr($field->nodeValue, 0 , 8) === "checkbox"){

                if(!in_array(substr($field->nodeValue, 0, -2), $allFurtherFields)){
                    $allFurtherFields[] = substr($field->nodeValue, 0, -2);
                }

            }else if($field->nodeValue === "submit"){
                $submitButton = $field->nodeValue;
            }else{
                if(!in_array($field->nodeValue, $allFurtherFields)){
                    $allFurtherFields[] = $field->nodeValue;
                }
            }

        }    

        return ["submit" => $submitButton, "labels" => $this->getAllLabels($dom), "fields" => $allFurtherFields];
    }
    
    /**
     * Erfasse alle Labels der Formularfelder
     *
     * @param  object $dom
     * @return array
     */

    private function getAllLabels(object $dom) : array{
        $domXPath = new DomXPath($dom);
        
        $allLabels = [];
        $labels = $domXPath->query("//label[contains(@class, 'form-label')]");

        if($labels->length > 0){
            foreach($labels as $label){
                $allLabels[] = $label->nodeValue;
            }
        }
    
        return $allLabels;
    }
    
    /**
     * Erfasse das Name-Attribut alle Felder, welche ein Pflichtfeld sind
     *
     * @param  object $dom
     * @return array
     */

    private function getRequiredFieldNames(object $dom) : array{
        $domXPath = new DomXPath($dom);
        $requiredFields = [];

        // Erfasse das Name-Attribut aller Elemente, die das Attribut required besitzen
        $fields = $domXPath->query("//*[contains(@required, 'required')]/@name");

        foreach($fields as $field){
            // Das [] wird von der nodeValue entfernt
            if(substr($field->nodeValue, 0, 13) == "checkboxfield"){
                $requiredFields[] = substr($field->nodeValue, 0, -2);
            }else{
                $requiredFields[] = $field->nodeValue;
            }
            
            
        }

        return $requiredFields;
    }
        
    /**
     * Baut den PHP-Code entsprechend der erfassten Name-Attribute zusammen
     *
     * @param  array $fields
     * @param  array $requiredFields
     * @param  string $receiver
     * @return string
     */
    
    private function buildPHPCodeTogether(array $fields, array $requiredFields, string $receiver) : string{
        $phpCode = '<?php
            
        ';

        
        // 1. Schritt: Notwendige Variablen initialsieren & PHP-Mailer hinzufügen falls $receiver exisitiert
        if(!empty($receiver)){
            $phpCode .= "\r\n" . 'use PHPMailer\PHPMailer\PHPMailer; ' .  "\r\n" . 'use PHPMailer\PHPMailer\Exception; ' .  "\r\n" . '// 1. Ändere die Pfade zu den Dateien' . "\r\n" .  'require "PATHTOPHPMAILER/src/Exception.php"; ' .  "\r\n" . 'require "PATHTOPHPMAILER/src/PHPMailer.php";' .  "\r\n" . 'require "PATHTOPHPMAILER/src/SMTP.php";
            ';
        }
        
        
        $phpCode .= "\r\n" . '$error = null;' .  "\r\n" . '$success = null;
        ';

        // 2. Schritt: Wurde das Formular abgeschickt?
        $phpCode .= "\r\n\r\n" . 'if(isset($_POST["' . $fields["submit"] . '"])){' . "\r\n\r\n\t";

        // 3. Schritt: Initialisierung der Variablen & Filtern der eingehenden Formulardaten
        foreach($fields["fields"] as $field){
            
            if(substr($field, 0, 5) == "email"){
                $phpCode .= '$' . $field . ' = filter_var(trim($_POST["' . $field . '"]), FILTER_VALIDATE_EMAIL) ?? null;' . "\r\n\t";
            }else if(substr($field, 0, 8) == "checkbox"){
                $phpCode .= '$' . $field . ' = filter_var_array($_POST["' . $field . '"], FILTER_SANITIZE_STRING) ?? null;' . "\r\n\t";
            }else{
                $phpCode .= '$' . $field . ' = filter_var(trim($_POST["' . $field . '"]), FILTER_SANITIZE_STRING) ?? null;' . "\r\n\t";
            }         
        }

        
       
        // 4. Schritt: Prüfen ob die Variablen leer sind & Fehlerbehandlung - Für Pflichtfelder
        
        if(count($requiredFields) > 0){
            $phpCode .= "\r\n\tif(";

            foreach($requiredFields as $key => $field){
                if(substr($field, 0, 8) == "checkbox"){
                    
                    if($key == 0){
                        $phpCode .= 'count($' . $field . ') == 0';
                    }else{
                        $phpCode .= ' || count($' . $field . ') == 0';
                    }
                }else{
                    if($key == 0){
                        $phpCode .= 'empty($' . $field . ')';
                    }else{
                        $phpCode .= ' || empty($' . $field . ')';
                    }
                }
                
                
            }

            $phpCode .= "){\r\n\t\t";
            $phpCode .= '$error = "<p class=\"text-danger mt-4 text-center\">Bitte füllen Sie alle Pflichtfelder aus!</p>";';
            $phpCode .= "\r\n\t}else{";
        }
        
        
        // 5.Schritt: Alle Formularfelder wurden ausgefüllt: Integration des PHP-Mailers 
    
        if(!empty($receiver)){
            $phpCode .= "\r\n" . '
                $day = date("d.m.y");
                $time = date("H.i");

                $mailer = new PHPMailer();
                $mailer->CharSet = "UTF-8"; 
                // 2. Lege den Absender mit Namen und E-Mail-Adresse fest. Die E-Mail kann auch eine fiktive E-Mail-Adresse sein
                $mailer->setFrom("SENDEREMAIL", "SENDERNAME"); 
                $mailer->addAddress("' . $receiver . '"); 
                $mailer->isHTML(true);
                // 3. Lege hier den Betreff fest
                $mailer->Subject = "DEINBETREFF";
                $mailer->Body = "<h1>Formulardaten:</h1>
                                <ul>'; 

            foreach($fields["fields"] as $key => $field){
                
                if(count($fields["labels"]) > 0){
                    if(substr($field, 0, 8) == "checkbox"){
                        $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<li><strong>' . utf8_decode($fields["labels"][$key]) . '</strong> " . htmlspecialchars(implode(", " , $' . $field . ')) . "</li>';                    
                    }else if(substr($field, 0, 8) == "textarea"){
                        $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<li><strong>' . utf8_decode($fields["labels"][$key]) . '</strong> " . nl2br(htmlspecialchars($' . $field . ')) . "</li>'; 
                    }else{
                        $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<li><strong>' . utf8_decode($fields["labels"][$key]) . '</strong> " . htmlspecialchars($' . $field  . ') . "</li>';
                    }
                }else{
                    if(substr($field, 0, 8) == "checkbox"){
                        $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<li>" . htmlspecialchars(implode(", " , $' . $field . ')) . "</li>';                    
                    }else if(substr($field, 0, 8) == "textarea"){
                        $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<li>" . nl2br(htmlspecialchars($' . $field . ')) . "</li>'; 
                    }else{
                        $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<li>" . htmlspecialchars($' . $field  . ') . "</li>';
                    }
                }
                
               
            }
            
            $phpCode .= "\r\n\t\t\t\t\t\t\t\t" . '</ul>';
            $phpCode .= "\r\n\t\t\t\t\t\t\t\t\t" . '<p>Gesendet am <strong>" . $day . "</strong> um <strong>" . $time .  " Uhr</strong></p>";
                
                if($mailer->send()){
                    $success = "<p class=\"text-success mt-4 text-center\">Das Formular wurde erfolgreich abgesendet!</p>";
                }else{
                    $error = "<p class=\"text-danger mt-4 text-center\">Es ist ein Fehler eingetreten: Bitte wende dich an test@exmaple.de!</p>";
                }
            ';


        }else{
            $phpCode .= "\r\n\t\t" . '$success = "<p class=\"text-success mt-4 text-center\">Das Formular wurde erfolgreich abgesendet!</p>";';
        }

        if(count($requiredFields) > 0){
            $phpCode .= "\r\n\t}";
        }
        
        $phpCode .= "\r\n}";

       

        return $phpCode;
    }
    
    /**
     * HTML-, PHP- & Installations-Datei werden erstellt und gezippt: Für eingeloggte User
     *
     * @param  bool $user
     * @param  string $receiver
     * @return bool
     */

    public function generateFormFiles(bool $user, string $receiver) : bool{
        $this->createFolder();
        $this->generateHTMLFile();
        $this->generatePHPFile($receiver);
        $this->generateInstallationFile($receiver);
        
        if($this->generateZip($user)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * HTML-, PHP-Datei werden geupdatet und die ZIP neu erstellt: Für eingeloggte User
     *
     * @param  bool $user
     * @param  string $receiver
     * @param  string $formName
     * @param  string $oldFormName
     * @return bool
     */

    public function updateFormFiles(bool $user, string $receiver, string $formName, string $oldFormName) : bool{

        $oldPath = $this->path . "/". $oldFormName;
        $newPath = $this->path . "/". $formName;
        
        // Wenn der neu gewählte und der alte Formularname nicht der gleiche sind 
        if($formName != $oldFormName){    

            if(file_exists($newPath)){
                echo "nameAlreadyExist";
                exit;
            }else {
                rename($oldPath, $newPath);
            }
                 
        }

        $this->generateHTMLFile();
        $this->generatePHPFile($receiver);
        $this->generateInstallationFile($receiver);
        
        if($this->generateZip($user)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Erstellt den HTML- & PHP-Code sowie die Installations-Anleitung und generiert mit diesen eine ZIP-Datei
     *
     * @param  bool $user
     * @param  string $receiver
     * 
     * @return bool|array
     */

    public function createFormForVisitor(bool $user, string $receiver){
        $this->createFolder();
        $this->setHTMLCode(); 
        $this->setPHPCode($user, $receiver);
        $this->setInstallationText($receiver);

        if($this->generateZip($user)){
            return $this->generateZip($user);
        }else{
            return false;
        }
    }

    
    /**
     *  Erstellt die Ordner für die Formulardateien
     *
     * @return void
     */

    private function createFolder(){
        
        if(!is_dir($this->pathToFiles) && !empty($this->pathToFiles)){
            mkdir($this->pathToFiles, 0777, true);
        }

        if(!is_dir($this->pathToZips)){
            mkdir($this->pathToZips, 0777, true);
        }

    }
    
    /**
     * Generiert die ZIP-Datei mit den Formularscripten
     *
     * @param  bool $user
     * @return bool|array
     */

    private function generateZip(bool $user){
        $zip = new ZipArchive();

        if($user){
            $html = file_get_contents($this->pathToFiles . "/form-html.php");
            $php = file_get_contents($this->pathToFiles . "/form-php.php");
            $installation = file_get_contents($this->pathToFiles . "/installation.txt");
        }else{
            $html = $this->html;
            $php = $this->php;
            $installation = $this->installation;
        }
        
        if(true === $zip->open($this->pathToZips . "form.zip", ZipArchive::CREATE)){
            $zip->addFromString("form-html.php", $html);
            $zip->addFromString("form-php.php", $php);
            $zip->addFromString("installation.txt", $installation);
            $zip->close();
                
            if($user){
                return true;
            }else{
                return ["action" => true, "downloadLink" =>  $this->downloadPath . "form.zip"];
            }
        }else{
            return false;
        }
   
    }


    /** Statische Funktionen */

    /**
     * Löscht das Verzeichnis mit all seinen Unterordnern und Dateien 
     *
     * @param  string $dir
     * @return bool
     */

    public static function deleteDir(string $dir) : bool{

        if(is_dir($dir)){
            
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
            
            foreach ($files as $file){
                if(!in_array($file->getBasename(), array(".", ".."))){
                    
                    if($file->isDir()){
                        rmdir($file->getPathname());
                        
                    }else if($file->isFile()){
                        unlink($file->getPathname());
                    }
                }
            }

          return rmdir($dir);
        }

        return false;
    }

      
    /**
     * Löschfunktion, welche alle generierten Formulardateien nach einer Stunde über ein Cronjob löscht
     *
     * @return void
     */
    public static function deleteVisitorsData(){
        
         $dir = $_SERVER['DOCUMENT_ROOT'] . "/project/generatedFormFiles/visitor/";
         $datetimeNow = new Datetime(date("Y-m-d H:i:s"));
         $minutes = 0;
 
         if(is_dir($dir)){
             
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
             
            foreach ($files as $file){
                if(!in_array($file->getBasename(), array(".", ".."))){

                    // Nur wenn es eine Datei ist, wird das Änderungsdatum erfasst und mit der aktuellen Datetime subtrahiert
                    if($file->isFile()){
                        $createdAt = new Datetime(date("Y-m-d H:i:s", filemtime($file->getPathname())));
                        $difference = $createdAt->diff($datetimeNow);
                    }

                    $hours = $difference->h;
                    
                    // Wenn die generierten Ordner und Dateien länger als 1 Stunde exisitieren, werden diese gelöscht
                    if($hours > 0){
                        if($file->isDir()){
                            rmdir($file->getPathname());
                        }else if($file->isFile()){
                            unlink($file->getPathname());
                        }
                    } 
                      
                }
            }     
           
        }
    }

        
    /**
     * Benennt den Haupt-Formularordner des Users um
     *
     * @param  string $name
     * @param  string $oldName
     * @return bool
     */

    public static function renameUserFormFolder(string $name, string $oldName) : bool{
        
        $oldPathToForms = $_SERVER["DOCUMENT_ROOT"] . "/project/generatedFormFiles/$oldName";
        $newPathToForms = $_SERVER["DOCUMENT_ROOT"] . "/project/generatedFormFiles/$name";
        
        if(file_exists($oldPathToForms)){
            if(rename($oldPathToForms, $newPathToForms)){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
        
    }

    
    /** Getter */
    
    /**
     * Gibt den Pfad der ZIP-Datei zurück
     *
     * @return string
     */
    
    public function getZipPath() : string{
        return $this->downloadPath . "form.zip";
    }

    /**
     * Gibt den HTML-Code für die API zurück
     *
     * @return string
     */

    public function getHTMLCodeForApi() : string{
        return $this->htmlForApi;
    }

    /**
     * Gibt den PHP-Code des Formulars für die API zurück
     *
     * @return string
     */

    public function getPHPCode() : string{
        return $this->php; 
    }
}