"use strict";

/**
 * Blendet das Modal ein
 */

function showModal(){
    $("#furtherSettings").modal("show");
}

/**
 * Schließt das Modal und führt bei der Route /form/create Einführungsschritt 3 aus
 * 
 * @param {string} actualRoute 
 * @param {Function} step3 
 * @param {Function} enableElementsStep3 
 */

function hideModal(actualRoute, step3, enableElementsStep3){
    // Close second and open third popover
    if(actualRoute == "/form/create"){
        step3(enableElementsStep3);
    }
    
    $("#furtherSettings").modal("hide");
}

export {showModal, hideModal};