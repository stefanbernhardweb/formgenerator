"use strict";

$(document).ready(function(){

    let apiButton = $("#copyApiKey");
    
    apiButton.on("click", copyApiKeyToClipboard);

    function copyApiKeyToClipboard(){
        let apiKey = $("#apiKey");

        apiButton.tooltip('hide');

        // Selektiert das Api-Key Span
        apiKey.select();
        
        // Api-Key wird in die Zwischenablage geschrieben
        navigator.clipboard.writeText(apiKey.text());
    }
    
});