"use strict";

$(document).ready(function(){
    let yourFormsContainer = $("section div").first();
    
    if(yourFormsContainer[0].children.length > 0){
        yourFormsContainer.attr("id", "yourForms");
    }
});