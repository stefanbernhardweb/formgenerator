"use strict";

let step = 0;

/**
 * Zeigt das Popover für Schritt 1 an
 */

function step1(){
    if(step == 0){
        $('#formName').popover({
            title: "Schritt 1",
            trigger: 'manual',
            container: 'body',
            placement: "top",
            content: "Lege den Formularnamen fest"
        }).popover("show");
    }   
}

/**
 * Zeigt das Popover für Schritt 2 an und blendet das Popover von Schritt 1 aus
 */

function step2(){
    if(step == 0){
        $('#formName').popover("hide");
        $('#editFurtherSettings').popover({
            html: true,
            title: "Schritt 2",
            trigger: 'manual',
            container: 'body',
            placement: "top",
            content: "Lege weitere Einstellungen fest"
        }).popover("show");
    }
}


/**
 * Zeigt das Popover für Schritt 3 an, blendet das Popover von Schritt 2 aus und schaltet alle Elemente des Formulargenerators frei
 * 
 * @param {function} enableElementsStep3 
 */

function step3(enableElementsStep3){
    if(step == 0){
        $('#editFurtherSettings').popover("hide");
        $('#aviableFormFields').popover({
            title: "Schritt 3",
            trigger: 'manual',
            container: 'body',
            placement: "top",
            content: "Stelle dein Formular zusammen"
        }).popover("show");

        enableElementsStep3()
    }
}

/**
 * Blendet das Popover von Schritt 3 aus und setzt den Durchlauf auf 1
 */

function step4(){
    $('#aviableFormFields').popover("hide");
    step = 1;
}

export {step, step1, step2, step3, step4};