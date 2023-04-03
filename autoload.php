<?php

// Quelle: https://www.php-fig.org/psr/psr-4/examples/

/* Modifiziert für den PHP-Mailer*/ 

spl_autoload_register(function ($class) {
    
    $prefixMailer = 'PHPMailer\\PHPMailer\\';
    $pmLen = strlen($prefixMailer);
    $pmNamespace = substr($class, 0, $pmLen);


    if($pmNamespace === "PHPMailer\\PHPMailer\\"){
        
        $base_dir = __DIR__ . "/vendor/phpmailer/src/";

        if (strncmp($prefixMailer, $class, $pmLen) !== 0) { 
            return;
        }

        $relative_class = substr($class, $pmLen);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    }else{
        $prefix = 'App\\';
        $base_dir = __DIR__ . "/app/";  

        $len = strlen($prefix);
    
        if (strncmp($prefix, $class, $len) !== 0) { 
            return;
        }
        
        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    }

    if (file_exists($file)) {
        require $file;
    }

    
});