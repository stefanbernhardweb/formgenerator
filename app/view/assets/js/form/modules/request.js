"use strict";

/**
 * Führt den POST-Request zur Speicherung des Formulars aus. Für Besucher wird nach erfolgreicher Erstellung ihrer ZIP-Datei diese sofort als Download angeboten.
 * 
 * @param {string} formName 
 * @param {string} receiver 
 * @param {string} form 
 * @param {string} formId 
 * @param {string} action 
 * @param {function} disableAll 
 */

function executeRequest(formName, receiver, form, formId, action, disableAll){

    $.ajax({
        method: "POST",
        url: "/project/form/" + action,
        data: {
            formName: formName,
            reveiver: receiver,
            form: form,
            formId: formId,
            action: action
        }
    }).done(function(msg){
        
        if(msg == "created"){
            window.location = "/project/home?form=created";
        }else if(msg == "updated"){
            window.location = "/project/home?form=updated";
        }else if(msg == "nameAlreadyExist"){
            $("#output").text("Du hast schon ein Formular mit diesem Namen. Bitte nutze einen anderen Namen!");
        }else if(msg == "error"){ 
            $("#output").text("Es ist ein Fehler aufgetreten. Bitte wende dich an den Seitenbetreiber unter stefan@example.de!");
        }else{

            if(msg){
                // Besucher: Download zur Verfügung stellen
                msg = JSON.parse(msg);
                
                if(msg.length > 0){
                    $("#actionBtnContainer").find("button").remove();
                    $("#actionBtnContainer").append("<a href='" + msg[0] + "' class='btn btn-success' download> Formular hier herunterladen </a>");
                    $("#success").text("Dein Formular wurde erfolgreich erstellt!");  
                    disableAll();
                }
            }
            
            
        }
       
    }).fail(function(jqXHR, status){
        $("#output").text("Es ist ein Fehler aufgetreten. Bitte wende dich an den Seitenbetreiber unter stefan@example.de!");
        //console.log("Fehler");
    });

}


export {executeRequest};