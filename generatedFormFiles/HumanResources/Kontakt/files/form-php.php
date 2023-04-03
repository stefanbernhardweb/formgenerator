<?php
            
        
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
// 1. Ändere die Pfade zu den Dateien
require "PATHTOPHPMAILER/src/Exception.php"; 
require "PATHTOPHPMAILER/src/PHPMailer.php";
require "PATHTOPHPMAILER/src/SMTP.php";
            
$error = null;
$success = null;
        

if(isset($_POST["submit"])){

	$textfield2 = filter_var(trim($_POST["textfield2"]), FILTER_SANITIZE_STRING) ?? null;
	$emailfield3 = filter_var(trim($_POST["emailfield3"]), FILTER_VALIDATE_EMAIL) ?? null;
	$textarea4 = filter_var(trim($_POST["textarea4"]), FILTER_SANITIZE_STRING) ?? null;
	
	if(empty($textfield2) || empty($emailfield3) || empty($textarea4)){
		$error = "<p class=\"text-danger mt-4 text-center\">Bitte füllen Sie alle Pflichtfelder aus!</p>";
	}else{

                $day = date("d.m.y");
                $time = date("H.i");

                $mailer = new PHPMailer();
                $mailer->CharSet = "UTF-8"; 
                // 2. Lege den Absender mit Namen und E-Mail-Adresse fest. Die E-Mail kann auch eine fiktive E-Mail-Adresse sein
                $mailer->setFrom("SENDEREMAIL", "SENDERNAME"); 
                $mailer->addAddress("contact@example.de"); 
                $mailer->isHTML(true);
                // 3. Lege hier den Betreff fest
                $mailer->Subject = "DEINBETREFF";
                $mailer->Body = "<h1>Formulardaten:</h1>
                                <ul>
									<li><strong>Ihr Name</strong> " . htmlspecialchars($textfield2) . "</li>
									<li><strong>Ihre E-Mail</strong> " . htmlspecialchars($emailfield3) . "</li>
									<li><strong>Ihre Nachricht</strong> " . nl2br(htmlspecialchars($textarea4)) . "</li>
								</ul>
									<p>Gesendet am <strong>" . $day . "</strong> um <strong>" . $time .  " Uhr</strong></p>";
                
                if($mailer->send()){
                    $success = "<p class=\"text-success mt-4 text-center\">Das Formular wurde erfolgreich abgesendet!</p>";
                }else{
                    $error = "<p class=\"text-danger mt-4 text-center\">Es ist ein Fehler eingetreten: Bitte wende dich an test@exmaple.de!</p>";
                }
            
	}
}