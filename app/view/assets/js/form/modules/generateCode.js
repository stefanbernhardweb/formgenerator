"use strict";

let form;

/**
 * Generiert den HTML-Code des Formulars für den POST-Request/das Speichern
 */

function generateHTMLCodeOfForm(){
    let formFields = $(".card-body");

    // Formular zusammenstellen
    form = "<form method='POST'>";
    formFields.each(function(i, element){
        $(element).find(".form-group").addClass("mt-3");
        form += $(element).html(); 
    });

    form += "</form>";

}

/**
 * Gibt den generierten HTML-Code des Formulars zurück
 * 
 * @returns string
 */

function getHTMLCodeOfForm(){
    return form;
}

export {generateHTMLCodeOfForm, getHTMLCodeOfForm};