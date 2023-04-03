<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/mainMenu.php"; ?>

<main class="container">
    <section class="mt-5 mb-5">
        <h3>Unsere API</h3> 
        <p>Über unsere API kannst du direkt über eine HTTP-Anfrage den generierten Formularcode auslesen und in deine Webseite integrieren. </p>

        <?php echo $data["apiCode"]; ?>
        <?php echo $data["requestForm"]; ?>  
    </section> 
    <section class="mt-4">
        <h3>Dokumentation</h3>

        <ul class="list-group list-unstyled border d-inline-block p-3 mt-3 mb-3">
            <li>1. <a href="#einfuehrung">Einführung</a></li>
            <li>2. <a href="#codeAbfrage">Formular-Code über die API abfragen</a></li>
            <li>3. <a href="#pfadaenderung">Ändere den Pfad zu dem PHP-Mailer</a></li>
            <li>4. <a href="#weitereaenderungen">Weitere wichtige Änderungen</a></li>
            <li>5. <a href="#ordneranlegen">Lege den Ordner für das PHP-Script an und speichere es in diesem ab</a></li>
            <li>6. <a href="#codesausfuehren">Binde das PHP-Script ein und zeige das Formular an</a></li>
            <li>7. <a href="#beispielcode">Beispielcode ohne Mail-Versand</a></li>
            <li>8. <a href="#beispielcodeMailversand">Beispielcode mit Mail-Versand</a></li>
        </ul>

        <div id="einfuehrung" class="mt-3">
            <h5>Einführung</h5>
            <p>
                Das Formular nutzt das CSS-Framework Bootstrap für die Darstellung des Formulars und für den Mail-Versand den PHP-Mailer. Bootstrap ist zwingend erforderlich. Der PHP-Mailer nur im Falle, wenn du eine Empfänger-Adresse
                für das Formular festgelegt hast. 
            </p>
            <p>Hier geht es zu den benötigten Ressourcen:</p>
            <ol>
                <li><a href="https://getbootstrap.com/docs/5.1/getting-started/introduction/" target="_blank">Binde Bootstrap in deine Webseite ein</a></li>
                <li><a href="https://github.com/PHPMailer/PHPMailer/archive/master.zip" target="_blank">Downloade den PHP-Mailer</a></li>
                <li><a href="https://www.html-seminar.de/online-stellen.htm" target="_blank">Lade den PHP-Mailer auf deinen FTP-Server</a></li>
            </ol>

            <p>Hast du bei deinem Formular keine Empfänger E-Mail-Adresse angegeben? Dann nehme <strong>Weg 1</strong>. Andernfalls ist <strong>Weg 2</strong> der Richtige für dich.</p>

            <h6>Weg 1: Ohne Mail-Versand</h6>
            <ol>
                <li><a href="#codeAbfrage" class="text-decoration-none">Formular-Code über die API abfragen</a></li>
                <li><a href="#ordneranlegen" class="text-decoration-none">Lege den Ordner für das PHP-Script an und speichere es in diesem ab</a></li>
                <li><a href="#codesausfuehren" class="text-decoration-none">Binde das PHP-Script ein und zeige das Formular an</a></li>
            </ol>
           
            <h6>Weg 2: Mit Mail-Versand</h6>
            <p>Damit der Mail-Versand erfolgreich funktioniert, musst du den PHP-Mailer auf den FTP-Server deines Webservers hochladen. Nachdem du diesen hochgeladen hast, musst du noch wichtige Schritte gehen, bevor dein Formular vollständig funktioniert. Befolge hierzu die folgende Reihenfolge: </p>
            <ol>
                <li><a href="#codeAbfrage" class="text-decoration-none">Formular-Code über die API abfragen</a></li>
                <li><a href="#pfadaenderung" class="text-decoration-none">Ändere den Pfad zu dem PHP-Mailer</a></li>
                <li><a href="#weitereaenderungen" class="text-decoration-none">Weitere wichtige Änderungen</a></li>
                <li><a href="#ordneranlegen" class="text-decoration-none">Lege den Ordner für das PHP-Script an und speichere es in diesem ab</a></li>
                <li><a href="#codesausfuehren" class="text-decoration-none">Binde das PHP-Script ein und zeige das Formular an</a></li>
            </ol>
            
        </div>
        <div id="codeAbfrage" class="mt-5">
            <h5>Formular-Code über die API abfragen</h5>
            <p>Um den HTML- & PHP-Code des gewünschten Formulars abfragen zu können musst du einen HTTP-POST-Request an die URL <strong>https://referenzen.the-webdeveloper.de/project/api/getForm</strong> mit folgenden Daten senden:</p>
            <ol>
                <li><strong>name</strong>: Dein Username</li>
                <li><strong>apiCode</strong>: Deinen Api-Schlüssel</li>
                <li><strong>form</strong>: Der Name des gewünschten Formulars</li>
            </ol>
            <p>Den Formularnamen findest du in deinem Mitgliederbereich bei deinen erstellten Formularen.</p>
            <p>So kann der HTTP-Post-Request über PHP aussehen:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
$url = "https://referenzen.the-webdeveloper.de/project/api/getForm";

$fields = [
    "name" => "deinName",
    "apiCode" => "deinenApiSchlüssel",
    "form" => "Formularname" // <- Beachte hier die Groß- und Kleinschreibung
];

$fields = http_build_query($fields);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 


$result = curl_exec($ch);
$result = json_decode($result);</code>
            </pre>

            <p>Auf den HTML- & PHP-Code kannst du dann wie folgt zugreifen:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
$html = $result->html;
$php = $result->php;</code>
            </pre>
        </div>
        <div id="pfadaenderung" class="mt-5">
            <h5>Ändere den Pfad zu dem PHP-Mailer</h5>
            <p>Der Pfad zum PHP-Mailer wird im generierten PHP-Code wie folgt angegeben:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
require "PATHTOPHPMAILER/src/Exception.php"; 
require "PATHTOPHPMAILER/src/PHPMailer.php";
require "PATHTOPHPMAILER/src/SMTP.php";</code>
            </pre>

            <p>Um den Pfad zu dem PHP-Mailer nun zu ändern, kannst du die PHP-Funktion <strong><a href="https://www.php.net/manual/de/function.str-replace.php" target="_blank">str_replace()</a></strong> nutzen.</p>
            <p>Füge hierzu einer der beiden Möglichkeiten nach dem HTTP-POST-Request zu deinem PHP-Code hinzu und ersetze den Platzhalter <strong>deinPfadZumPHPMailer</strong>: </p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
// 1. Möglichkeit
$php = str_replace("PATHTOPHPMAILER", "deinPfadZumPHPMailer", $result->php);

// 2. Möglichkeit
$php = $result->php;
$php = str_replace("PATHTOPHPMAILER", "deinPfadZumPHPMailer", $php);</code>
            </pre>
        </div>
        <div id="weitereaenderungen" class="mt-5">
            <h5 class="mb-3">Weitere wichtige Änderungen</h5>
           
            <h6 class="mt-4">1. Ändere die E-Mail-Adresse sowie den Namen des Senders</h6>
            <p>Die E-Mail-Adresse sowie der Name des Senders sind im generierten PHP-Code wie folgt angegeben:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
// E-Mail-Adresse & Name des Senders der E-Mail
$mailer->setFrom("SENDEREMAIL", "SENDERNAME");</code>
            </pre>
            <p>Um diese Daten nun zu ändern, kannst du die PHP-Funktion <strong><a href="https://www.php.net/manual/de/function.str-replace.php" target="_blank">str_replace()</a></strong> nutzen.</p>
            <p>Füge hierzu den folgenden Code hinzu und ersetze die Platzhalter <strong>E-Mail Adresse des Senders</strong> & <strong>Name des Senders</strong>: </p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
// E-Mail-Adresse des Senders der E-Mail ändern
$php = str_replace("SENDEREMAIL", "E-Mail Adresse des Senders", $php);

// Name des Senders der E-Mail ändern
$php = str_replace("SENDERNAME", "Name des Senders", $php);</code>
            </pre>
            <h6 class="mt-4">2. Ändere den Betreff der E-Mail</h6>
            <p>Der Betreff der E-Mail wird im generierten PHP-Code wie folgt angegeben:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
// Betreff der E-Mail
$mailer->Subject = "DEINBETREFF";</code>
            </pre>
            <p>Um diese Daten nun zu ändern, kannst du wie bei Punkt 1, die PHP-Funktion <strong><a href="https://www.php.net/manual/de/function.str-replace.php" target="_blank">str_replace()</a></strong> nutzen.</p>
            <p>Füge hierzu den folgenden Code hinzu und ersetze den Platzhalter <strong>Gewünschter Betreff der E-Mail</strong>: </p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
// Betreff der E-Mail ändern
$php = str_replace("DEINBETREFF", "Gewünschter Betreff der E-Mail", $php);</code>
            </pre>
            <h6 class="mt-4">3. Ändere die E-Mail-Adresse, an die sich die Nutzer bei Fehlerfällen wenden können</h6>
            <p>Im generierten PHP-Code wird bei einem Fehlerfall des E-Mail-Versandes eine E-Mail-Adresse angegeben, über die sich die Nutzer an den Webseiten-Betreiber wenden können. Als Standard-Email ist <strong>test@example.de</strong> angegeben.</p>
            <p>Füge hierzu den folgenden Code hinzu und ersetze den Platzhalter <strong>E-Mail des Webseitenbetreibers</strong>: </p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
// E-Mail für Fehlerfälle ändern
$php = str_replace("test@exmaple.de", "E-Mail des Webseitenbetreibers", $php);</code>
            </pre> 
        </div>
        <div id="ordneranlegen" class="mt-5">
            <h5>Lege den Ordner für das PHP-Script an und speichere es in diesem ab</h5>
            <p>Nachdem du nun alle Änderungen nach der Dokumentation vorgenommen hast, musst du auf deinem Webserver ein Ordner anlegen, in dem das PHP-Script mit dem generierten PHP-Code abgespeichert wird. Danach kannst du das PHP-Script in diesem speichern.</p>
            
            <h6>1. Lege den Ordner für das PHP-Script an</h6>
            <p>Damit du einen Ordner für das PHP-Script anlegen kannst, nutze die PHP-Funktion <strong><a href="https://www.php.net/manual/en/function.mkdir.php" target="_blank">mkdir()</a></strong>.</p>
            <p>Füge hierzu folgenden Code hinzu und ersetze den Platzhalter <strong>Ordner des PHP-Scripts</strong>:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
mkdir("Ordner des PHP-Scripts", 0777, true);</code>
            </pre>

            <h6>2. Speichere das PHP-Script mit dem PHP-Code deines Formulars in dem Ordner</h6>
            <p>Damit du das PHP-Script mit dem PHP-Code deines Formulars in dem Ordner speichern kannst, nutze die PHP-Funktion <strong><a href="https://www.php.net/manual/en/function.file-put-contents.php" target="_blank">file_put_contents()</a></strong>. Dieser Funktion übergibst du den Pfad zum PHP-Script und den PHP-Code deines Formulars.</p>
            <p>Füge hierzu folgenden Code hinzu und ersetze den Platzhalter <strong>Name des PHP-Scripts</strong>:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
file_put_contents("Name des PHP-Scripts", $php);</code>
            </pre>
        </div>


        <div id="codesausfuehren" class="mt-5">
            <h5>Binde den PHP-Code ein und zeige das Formular an</h5>
            <p>Nun musst du den PHP-Code nurnoch einbinden, das Formular anzeigen und die Ausgabe der Erfolgs- und Fehlermeldung hinzufügen.</p>
            
            <h6>1. PHP-Code einbinden</h6>
            <p>Damit du den PHP-Code einbinden kannst, brauchst du die PHP-Funktion <strong><a href="https://www.php.net/manual/en/function.require.php" target="_blank">require()</a></strong>. Übergebe dieser den Pfad zum PHP-Script deines Formulars.</p>
            <p>Füge hierzu folgenden Code hinzu und ersetze den Platzhalter <strong>Pfad zum PHP-Script deines Formulars</strong>:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
require "Pfad zum PHP-Script deines Formulars";</code>
            </pre>

            <h6>2. Dein Formular anzeigen</h6>
            <p>Damit dein Formular angezeigt wird, musst du dieses über die PHP-Funktion <strong><a href="https://www.php.net/manual/en/function.echo.php" target="_blank">echo</a></strong> ausgeben:</p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
echo $html;</code>
            </pre>

            <h6>3. Erfolgs- & Fehlermeldung erfassen und ausgeben</h6>
            <p>Damit beim Formular die Erfolgs- und Fehlermeldung auch ausgegeben wird, musst du nach der Anzeige deines Formulars diese ausgeben. Im PHP-Code wird für die Erfolgsmeldung die Variable <strong>$success</strong> und für die 
            Fehlermeldung die Variable <strong>$error</strong> genutzt. Füge hierzu folgenden PHP-Code unterhalb der Formularausgabe hinzu: </p>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
echo $success ?? $error;</code>
            </pre>

            <p>Nun hast du alle Änderungen erfolgreich vorgenommen, damit dein Formular angezeigt wird und vollständig funktioniert.</p>
        </div>
        <div id="beispielcode" class="mt-5">
            <h5 class="mb-3">Beispielcode ohne Mailversand</h5>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
&lt?php

$url = 'https://referenzen.the-webdeveloper.de/project/api/getForm';

// Setze hier deine Daten ein
$fields = [
    "name" => "username",
    "apiCode" => "api-schlüssel",
    "form" => "formularname"
];

$fields = http_build_query($fields);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$result = curl_exec($ch);
$result = json_decode($result);

// HTML- & PHP-Code in zwei Variablen ablegen
$html = $result->html;
$php = $result->php;

// Ordner für das PHP-Skript erstellen
mkdir("php", 0777, true);

//PHP-Code in eine Datei abspeichern & wenn dies erfolgreich war, wird dieses PHP-Script eingebunden
if(file_put_contents("./php/form.php", $php)){
    require "./php/form.php";
}

?&gt

&lt!DOCTYPE html&gt
&lthtml lang="en"&gt
&lthead&gt
    &ltmeta charset="UTF-8"&gt
    &ltmeta http-equiv="X-UA-Compatible" content="IE=edge"&gt
    &ltmeta name="viewport" content="width=device-width, initial-scale=1.0"&gt
    &lttitle&gtBeispielcode&lt/title&gt

    &ltlink href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"&gt
&lt/head&gt
&ltbody&gt
    &lt!-- Formular anzeigen --&gt
    &lt?php echo $html; ?&gt
    &lt!-- Erfolgs- und Fehlermeldung anzeigen --&gt
    &lt?php echo $success ?? $error; ?&gt
&lt/body&gt
&lt/html&gt</code>
            </pre> 
        </div>
        <div id="beispielcodeMailversand" class="mt-5">
            <h5 class="mb-3">Beispielcode mit Mailversand</h5>
            <pre class="bg-dark ps-3 ">
                <code class="text-warning">  
&lt?php

$url = 'https://referenzen.the-webdeveloper.de/project/api/getForm';

// Setze hier deine Daten ein
$fields = [
    "name" => "username",
    "apiCode" => "api-schlüssel",
    "form" => "formularname"
];

$fields = http_build_query($fields);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$result = curl_exec($ch);
$result = json_decode($result);

// HTML- & PHP-Code in zwei Variablen ablegen
$html = $result->html;
$php = $result->php;

// Pfad zum PHP-Mailer ändern
$php = str_replace("PATHTOPHPMAILER", "phpmailer", $php);

// E-Mail-Adresse des Senders der E-Mail ändern
$php = str_replace("SENDEREMAIL", "sender@example.de", $php);

// Name des Senders der E-Mail ändern
$php = str_replace("SENDERNAME", "Testsender", $php);

// Betreff der E-Mail ändern
$php = str_replace("DEINBETREFF", "Testbetreff", $php);

// E-Mail für Fehlerfälle ändern
$php = str_replace("test@exmaple.de", "webseitenbetreiber@example.de", $php);

// Ordner für die PHP-Skript erstellen
mkdir("php", 0777, true);

//PHP-Code in eine Datei abspeichern & wenn dies erfolgreich war, wird dieses PHP-Script eingebunden
if(file_put_contents("./php/form.php", $php)){
    require "./php/form.php";
}

?&gt

&lt!DOCTYPE html&gt
&lthtml lang="en"&gt
&lthead&gt
    &ltmeta charset="UTF-8"&gt
    &ltmeta http-equiv="X-UA-Compatible" content="IE=edge"&gt
    &ltmeta name="viewport" content="width=device-width, initial-scale=1.0"&gt
    &lttitle&gtBeispielcode&lt/title&gt

    &ltlink href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"&gt
&lt/head&gt
&ltbody&gt
    &lt!-- Formular anzeigen --&gt
    &lt?php echo $html; ?&gt
    &lt!-- Erfolgs- und Fehlermeldung anzeigen --&gt
    &lt?php echo $success ?? $error; ?&gt
&lt/body&gt
&lt/html&gt</code>
            </pre> 
        </div>
    </section>

</main>
<?php include "app/view/includes/footer.php"; ?>