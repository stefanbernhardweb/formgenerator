"use strict";

let formName;

/**
 * Sperrt alle Elemente des Formulargenerators, bis auf das Feld des Formularnamen
 */

function disableElements(){
    $(".list-group").addClass("disabled");
    $("#formContainer").addClass("disabled");
    $("#editFurtherSettings").addClass("disabled");
    $("#safeForm").addClass("disabled");
}

/**
 * Sperrt alle Elemente des Formulargenerators
 */

function disableAll(){
    $(".list-group").addClass("disabled");
    $("#formContainer").addClass("disabled");
    $("#formNameEdit").addClass("disabled");
    $("#editFurtherSettings").addClass("disabled");
    $("#safeForm").addClass("disabled");
}

/**
 * Aktiviert alle Elemente des Formulargenerators, bis auf den Formularnamen
 */

function enableAllElements(){
    $("#editFurtherSettings").removeClass("disabled");
    $(".list-group").removeClass("disabled");
    $("#formContainer").removeClass("disabled");
    $("#safeForm").removeClass("disabled");
}

/**
 * Aktiviert alle Elemente des Formulargenerators, für Schritt 2
 */

function enableElementsStep2(){
    $("#editFurtherSettings").removeClass("disabled");
}

/**
 * Aktiviert alle Elemente des Formulargenerators, für Schritt 3
 */

function enableElementsStep3(){
    $(".list-group").removeClass("disabled");
    $("#formContainer").removeClass("disabled");
    $("#safeForm").removeClass("disabled");
}

/**
 * Macht das Formularnamen-Feld bearbeitbar
 */

function setFormNameEditable(){
    $("#formName").attr("contenteditable", true);
    $("#formName").css("border", "2px solid black");
    $("#formName").addClass("rounded-3");
    $("#formName").focus();
    $("#formNameEdit").css("display", "none");
    $("#formNameEditClose").css("display", "inline-block");
}

/**
 * 
 */

/**
 * Macht das Formularnamen-Feld unbearbeitbar, überprüft, ob ein Formularname existiert und führt dementsprechend weitere Aktionen aus.
 * Wenn der Formularname nicht existiert, werden alle Elemente des Formulargenerators gesperrt. 
 * 
 * @param {function} step2 
 */

function setFormNameUneditable(step2){
    $("#formName").attr("contenteditable", false);
    $("#formName").css("border", "0px solid black");
    $("#formNameEdit").css("display", "inline-block");
    $("#formNameEditClose").css("display", "none");

    formName = $("#formName")[0].innerText;
    
    if(formName){

        if(step2){
            step2();
            enableElementsStep2();  
        }else{
            enableAllElements();
        }
             
    }else{
        disableElements();
    }
} 

/**
 * Sorgt dafür, dass wenn der Anwender Enter drückt, das Formnamen-Feld auf unbearbeitbar gesetzt wird
 * 
 * @param {*} e 
 * @param {function} step2 
 */

function actionOnClickEnter(e, step2){
    if(e.which == 13){
        setFormNameUneditable(step2);
    }    
}

/**
 * Setzt den Formularfelder-Container auf sortable, damit die Position der einzelnen Felder direkt in diesem geändert werden kann 
 */

function setFormContainerSortable(){
    $("#sortable").sortable({
        placeholder: "ui-state-highlight"
    });
}

export {disableElements, disableAll, enableElementsStep3, setFormNameEditable, setFormNameUneditable, actionOnClickEnter, setFormContainerSortable};