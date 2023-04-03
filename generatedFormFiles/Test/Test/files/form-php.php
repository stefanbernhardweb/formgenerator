<?php
            
        
$error = null;
$success = null;
        

if(isset($_POST["submit"])){

	$textfield2 = filter_var(trim($_POST["textfield2"]), FILTER_SANITIZE_STRING) ?? null;
	
	if(empty($textfield2)){
		$error = "<p class=\"text-danger mt-4 text-center\">Bitte füllen Sie alle Pflichtfelder aus!</p>";
	}else{
		$success = "<p class=\"text-success mt-4 text-center\">Das Formular wurde erfolgreich abgesendet!</p>";
	}
}