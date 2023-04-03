"use strict";

/**
 * Setzt die Empfänger-Email, an die das Kontaktformular gesendet werden soll und führt entsprechend der Eingabe weitere Schritte aus.
 * Wenn das Formular leer abgesendet wird, wird das Input-Feld rot umrandet, andernfalls wird der Rahmen auf Normalfarbe gesetzt und das Modal geschlossen
 * 
 * @param {*} e 
 * @param {string} actualRoute 
 * @param {function} hideModal 
 * @param {function} step3 
 * @param {function} enableElementsStep3 
 */

function setReceiverEmail(e, actualRoute, hideModal, step3, enableElementsStep3){
    e.preventDefault();
    let receiverField = $("#receiver");
    let receiver = receiverField.val();

    if(receiver == ""){
        receiverField.css("border", "1px solid red");
    }else{
        receiverField.css("border", "1px solid #ced4da");
        
        hideModal(actualRoute, step3, enableElementsStep3);
    }
}

/**
 * Gibt den Formularnamen des Formulars zurück
 * 
 * @returns string
 */

function getFormName(){
    return $("#formName").text();
}

/**
 * Gibt die Empfänger-Email des Formulars zurück
 * 
 * @returns string
 */

function getReceiverEmail(){
    return $("#receiver").val();
}


export {setReceiverEmail, getFormName, getReceiverEmail};