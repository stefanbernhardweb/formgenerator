"use strict";


/**
 * Gibt die Rahmenfarbe, den Box-Schatten, die Hintergrundfarbe und die Textfarbe der Hintergrundfarben-Klasse zurück
 * 
 * @param {string} bg 
 * @returns array
 */

function getColorCode(bg){
    let borderColor, boxShadow, backgroundColor, textColor;

    switch(bg){
        case "bg-primary":
            borderColor = "rgba(13, 110, 253, 1)";
            boxShadow = "0px 0px 5px rgba(13, 110, 253, 1)";
            backgroundColor = "rgba(13, 110, 253, .2)";
            textColor = "white";
            break;
        case "bg-secondary":
            borderColor = "rgba(108, 117, 125, 1)";
            boxShadow = "0px 0px 5px rgba(108, 117, 125, 1)";
            backgroundColor = "rgba(108, 117, 125, .2)";
            textColor = "white";
            break;
        case "bg-success":
            borderColor = "rgba(25, 135, 84, 1)";
            boxShadow = "0px 0px 5px rgba(25, 135, 84, 1)";
            backgroundColor = "rgba(25, 135, 84, .2)";
            textColor = "white";
            break;
        case "bg-warning":
            borderColor = "rgba(255, 193, 7, 1)";
            boxShadow = "0px 0px 5px rgba(255, 193, 7, 1)";
            backgroundColor = "rgba(255, 193, 7, .2)";
            textColor = "black";
            break;
        case "bg-info":
            borderColor = "rgba(13, 202, 240, 1)";
            boxShadow = "0px 0px 5px rgba(13, 202, 240, 1)";
            backgroundColor = "rgba(13, 202, 240, .2)";
            textColor = "white";
            break;
        case "bg-dark":
            borderColor = "rgba(33, 37, 41, 1)";
            boxShadow = " 0px 0px 5px rgba(33, 37, 41, 1)";
            backgroundColor = "rgba(33, 37, 41, .2)";
            textColor = "white";
            break;
        case "bg-light":
            borderColor = "rgba(248, 249, 250, 1)";
            boxShadow = " 0px 0px 5px rgba(248, 249, 250, 1)";
            backgroundColor = "rgba(248, 249, 250, .2)";
            textColor = "black";
            break;
    }

    return [borderColor, boxShadow, backgroundColor, textColor];
}

export {getColorCode};