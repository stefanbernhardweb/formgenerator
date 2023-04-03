<?php

namespace App\Controller;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

// Benutzt den PHP-Mailer aus dem vendor-Ordner

class Email{

    private $mailer = null;
    
    /**
     * Instanziierung des PHP-Mailers
     *
     * @return void
     */

    public function __construct(){
        $this->mailer = new PHPMailer();
    }
    
    /**
     * Sendet die Verifizierungsemail nach der erfolgreichen Registration an den User
     *
     * @param  string $name
     * @param  string $receiver
     * @param  int    $userId
     * @param  string $verifyHash
     * @return bool
     */

    public function sendVerificationEmailForRegistry(string $name, string $receiver, int $userId, string $verifyHash) : bool{

        $this->mailer->CharSet = "UTF-8"; 
        $this->mailer->setFrom("stefan@example.de", "Formgenerator"); 
        $this->mailer->addAddress($receiver); 
        $this->mailer->isHTML(true);
        $this->mailer->Subject = "Deine Registrierung bei Formgenerator: Verifiziere jetzt deinen Account"; 
        // TODO: Verifizierungslink ändern. Online zu : https://develop.enter-the-web.de/ | Lokal auf Xampp zu: http://localhost/
        $template = "<body style='margin: 0; padding: 0;'>
                            <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse;'>
                                <tr>
                                    <td align='center' bgcolor='#5cb85c' style='padding: 30px 0 30px 0;'>
                                        <h1 style='font-size: 16pt; color: white; font-family: Arial;'>FORMGENERATOR<h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td width='600' valign='top'>
                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                            <tr>
                                                <td style='padding: 40px 30px 15px 30px;'>
                                                    Liebe*r " . ucfirst(htmlspecialchars($name)) .  ",<br/><br/>
                                                    vielen Dank für dein Interesse an unserer Platform. Damit du nun alle Funktionen unserer Platform nutzen kannst, musst du dich über folgenden Link verifizieren:<br/><br/>
                                                    <a href='https://referenzen.the-webdeveloper.de/project/verify?id=" . $userId . "&verifyHash=" . $verifyHash . "'>Verifiziere jetzt deinen Account</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 10px 30px 40px 30px;'>
                                                <p>Wir freuen uns bereits dich als neues Mitglied begrüßen zu dürfen. <br/>
                                                Dein Formgenerator-Team</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='font-size: 0; line-height: 0;' width='20'>
                                                    &nbsp;
                                                </td>  
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>";



        $this->mailer->Body = $template;
        
        if($this->mailer->send()){
            return true;
        }
        
        return false;
        
    }

}