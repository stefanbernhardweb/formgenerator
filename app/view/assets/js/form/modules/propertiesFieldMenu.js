"use strict";

//#region Templates

/**
 * Verschiedene Templates für die einzelnen Eigenschaften-Menüs der Formularfelder
 */

/**
 * Eigenschaftenmenü-Template für Input Felder mit Type: Text, Email, Passwort
 */
const menuTemplateText = `<ul class="list-unstyled list-group">
                            <li class="mb-3 text-center position-relative list-group-item" id="menuHead">
                                <button id="closePropertiesMenu" class="btn pt-0 pb-0 px-2 position-absolute" title="Menü schließen"><i class="fas fa-times"></i></button>
                                <span class="d-inline-block">Eigenschaften Menü</span>
                            </li>
                            <li class="mb-1 px-2">
                                <span class="property d-inline-block">
                                    <i class="fas fa-info-circle text-primary" value="label" data-toggle="popover"  title="Bezeichnung"></i> Bezeichnung:
                                    <i class="required text-danger">*</i>
                                </span> 
                            </li>
                            <li class="mb-2 px-2">
                                <input type="text" class="propertyValue form-control" id="label" value="<label>">
                            </li>                       
                            <li class="mb-1 px-2">
                                <span class="property d-inline-block">
                                    <i class="fas fa-info-circle text-primary" value="placeholder" data-toggle="popover"  title="Platzhalter"></i> Platzhalter:
                                </span>
                            </li>
                            <li class="mb-2 px-2">
                                <input type="text" class="propertyValue form-control" id="placeholder" value="<placeholder>">
                            </li> 
                            <li class="mb-4 px-2 d-flex justify-content-between">
                                <span class="property d-inline-block">
                                    <i class="fas fa-info-circle text-primary" value="mandatoryField" data-toggle="popover"  title="Pflichtfeld"></i> Pflichtfeld:
                                </span>
                                <span class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="mandatoryField" <checked>>
                                </span>
                            </li>
                        </ul>`;

/**
 * Eigenschaftenmenü-Template für die Textareas
 */

const menuTemplateTextarea = `<ul class="list-unstyled list-group">
                                <li class="mb-3 text-center position-relative list-group-item" id="menuHead">
                                    <button id="closePropertiesMenu" class="btn pt-0 pb-0 px-2 position-absolute" title="Menü schließen"><i class="fas fa-times"></i></button>
                                    <span class="d-inline-block">Eigenschaften Menü</span>
                                </li>
                                <li class="mb-1 px-2">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="label" data-toggle="popover" title="Bezeichnung"></i> Bezeichnung:
                                        <i class="required text-danger">*</i>
                                    </span> 
                                </li>
                                <li class="mb-2 px-2">
                                    <input type="text" class="propertyValue form-control" id="label" value="<label>">
                                </li>                       
                                <li class="mb-1 px-2">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="placeholder" data-toggle="popover"  title="Platzhalter"></i> Platzhalter:
                                    </span>
                                </li>
                                <li class="mb-2 px-2">
                                    <input type="text" class="propertyValue form-control" id="placeholder" value="<placeholder>">
                                </li> 
                                <li class="mb-1 px-2">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="rows" data-toggle="popover" title="Reihen"></i> Reihen:
                                    </span> 
                                </li>
                                <li class="mb-2 px-2">
                                    <input type="text" class="propertyValue form-control" id="rows" value="<rows>">
                                </li> 
                                <li class="mb-4 px-2 d-flex justify-content-between">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="mandatoryField" data-toggle="popover"  title="Pflichtfeld"></i> Pflichtfeld:
                                    </span>
                                    <span class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="mandatoryField" <checked>>
                                    </span>
                                </li>
                            </ul>`;

/**
 * Eigenschaftenmenü-Template für den Sende-Button
 */

const menuTemplateButton = `<ul class="list-unstyled list-group">
                                <li class="mb-3 text-center position-relative list-group-item" id="menuHead">
                                    <button id="closePropertiesMenu" class="btn pt-0 pb-0 px-2 position-absolute" title="Menü schließen"><i class="fas fa-times"></i></button>
                                    <span class="d-inline-block">Eigenschaften Menü</span>
                                </li>
                                <li class="mb-1 px-2">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="value" data-toggle="popover" title="Wert"></i> Wert:
                                    </span> 
                                </li>
                                <li class="mb-2 px-2">
                                    <input type="text" class="propertyValue form-control" id="value" value="<value>">
                                </li>   
                                <li class="mb-1 px-2">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="backgroundColor" data-toggle="popover" title="Hintergrundfarbe"></i> Hintergrundfarbe:
                                    </span> 
                                </li>
                                <li class="mb-2 px-2">
                                    <input type="color" class="propertyValue form-control" id="backgroundColor" value="<backgroundColor>">
                                </li>  
                                <li class="mb-1 px-2">
                                    <span class="property d-inline-block">
                                        <i class="fas fa-info-circle text-primary" value="textcolor" data-toggle="popover" title="Textfarbe"></i> Textfarbe:
                                    </span> 
                                </li>
                                <li class="mb-2 px-2">
                                    <input type="color" class="propertyValue form-control" id="textColor" value="<textColor>">
                                </li>                    
                            </ul>`;

/**
 * Eigenschaftenmenü-Template für Checkboxen & Radio-Buttons
 */                            

const menuTemplateBoxes = `<ul class="list-unstyled list-group">
                            <li class="mb-3 text-center position-relative list-group-item" id="menuHead">
                                <button id="closePropertiesMenu" class="btn pt-0 pb-0 px-2 position-absolute" title="Menü schließen"><i class="fas fa-times"></i></button>
                                <span class="d-inline-block">Eigenschaften Menü</span>
                            </li>
                            <li class="mb-1 px-2">
                                <span class="property d-inline-block">
                                    <i class="fas fa-info-circle text-primary" value="label" data-toggle="popover"  title="Bezeichnung"></i> Bezeichnung:
                                    <i class="required text-danger">*</i>
                                </span> 
                            </li>
                            <li class="mb-2 px-2">
                                <input type="text" class="propertyValue form-control" id="label" value="<label>">
                            </li>                       
                            <li class="mb-1 px-2">
                                <span class="property d-inline-block">
                                    <i class="fas fa-info-circle text-primary" value="options" data-toggle="popover"  title="Optionen"></i> Optionen:
                                </span>
                            </li>
                            <li class="mb-2 px-2">
                                <textarea class="propertyValue form-control" rows="5" id="options"><options></textarea>
                            </li> 
                            <li class="mb-4 px-2 d-flex justify-content-between">
                                <span class="property d-inline-block">
                                    <i class="fas fa-info-circle text-primary" value="mandatoryField" data-toggle="popover"  title="Pflichtfeld"></i> Pflichtfeld:
                                </span>
                                <span class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="mandatoryField" <checked>>
                                </span>
                            </li>
                        </ul>`;  
                        
/**
* Zum dynamischen Hinzufügen neuer Optionen
*/

const radioBtnTemplate = `<div class="form-check">
                                <input class="form-check-input" type="radio" value="<value>" name="<name>" id="<id>" data-id="<idAsInt>">
                                <label class="form-check-label" for="<for>">
                                    <innerText>
                                </label>
                            </div>`;

const checkboxTemplate = `<div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<value>" name="<name>" id="<id>" data-id="<idAsInt>">
                                <label class="form-check-label" for="<for>">
                                    <innerText>
                                </label>
                            </div>`;


//#endregion

//#region Main-Function

/**
 * Generiert das passende Eigenschaften-Menü und gibt dieses zurück
 * 
 * @param {string} type 
 * @param {string} fieldId 
 * @returns string
 */

function generatePropertiesMenu(type, fieldId){
    
    let menu;

    if(type == "Einzeiliges Textfeld" || type == "E-Mail" || type == "Passwort"){
        menu = createTextPropertiesMenu(fieldId, menuTemplateText);    
    }else if(type == "Mehrzeiliges Textfeld"){
        menu = createTextareaPropertiesMenu(fieldId, menuTemplateTextarea);    
    }else if(type == "Sende-Button"){
        menu = createButtonPropertiesMenu(fieldId, menuTemplateButton);  
    }else{
        menu = createBoxesPropertiesMenu(fieldId, menuTemplateBoxes); 
    }

    return menu;
}

/**
 * Zeigt das generierte Eigenschaften-Menü an
 * 
 * @param {*} e 
 * @param {string} type 
 * @param {string} fieldId 
 * @param {function} setSelectedField 
 * @param {array} colorCode 
 */

function showPropertiesMenu(e, type, fieldId, setSelectedField, colorCode){
    
    let menu, targetClass;

    // Erfasse den ersten Buchstaben des ersten Klassennamens
    targetClass = $(e.target).attr("class").split(" ");

    if(targetClass[1]){
        targetClass = targetClass[1];
    }
    
    /** 
     * Wenn das geklickte Element nicht der Löschen-Button ist wird das passende Eigenschaftenmenü erzeugt und angezeigt
     * */ 
    
    if(targetClass != "fa-trash" && targetClass != "btn-danger"){
        menu = generatePropertiesMenu(type, fieldId);

        $("#propertiesMenu").html(menu);
        
        $("#menuHead").css("background-color", colorCode[0]);
        $("#propertiesMenu").css("background-color", colorCode[2]);
        $("#menuHead span").css("color", colorCode[3]);
        $("#menuHead i").css("color", colorCode[3]);
       
    
        $("#aviableFormFields").css("display", "none");
        $("#propertiesMenu").css("display", "block");
        $("#closePropertiesMenu").on("click", function(e){
            hidePropertiesMenu(e, setSelectedField);
        });  
    }
    
   
}

/**
 * Blendet das Eigenschaften-Menü aus und das Verfügbare Formularfelder-Menü wieder ein
 * 
 * @param {*} e 
 * @param {function} setSelectedField 
 */

function hidePropertiesMenu(e, setSelectedField){  
    
    setSelectedField(e);
    
    $("#propertiesMenu").css("display", "none");
    $("#closePropertiesMenu").off();
    $("#aviableFormFields").css("display", "block");   
}
//#endregion

//#region Create-Functions

/**
 * Erstellt das Eigenschaften-Menü für Input-Felder mit den Typen: Text, Email, Passwort
 * 
 * @param {string} fieldId 
 * @param {string} template 
 * @returns string
 */

function createTextPropertiesMenu(fieldId, template){
    let label = $("#" + fieldId).find("label").text();
    let placeholder = $("#" + fieldId).find("input").attr("placeholder");
    let mandatoryField = $("#" + fieldId).find("span.required").text();

    template = template.replace("<label>", label);
    template = template.replace("<placeholder>", placeholder);

    template = checkIfRequired(mandatoryField, template);

    return template;    
}

/**
 * Erstellt das Eigenschaften-Menü für Textareas
 * 
 * @param {string} fieldId 
 * @param {string} template 
 * @returns string
 */

function createTextareaPropertiesMenu(fieldId, template){
    let label = $("#" + fieldId).find("label").text();
    let placeholder = $("#" + fieldId).find("textarea").attr("placeholder");
    let rows = $("#" + fieldId).find("textarea").attr("rows");
    let mandatoryField = $("#" + fieldId).find("span.required").text();

    template = template.replace("<label>", label);
    template = template.replace("<placeholder>", placeholder);
    template = template.replace("<rows>", rows);

    template = checkIfRequired(mandatoryField, template);

    return template;   
}

/**
 * Erstellt das Eigenschaften-Menü für den Sende-Button
 * 
 * @param {string} fieldId 
 * @param {string} template 
 * @returns string
 */

function createButtonPropertiesMenu(fieldId, template){
    let value = $("#" + fieldId).find("input").attr("value");
    let backgroundColor = rgbToHex($("#" + fieldId).find("input").css("backgroundColor"));
    let textColor = rgbToHex($("#" + fieldId).find("input").css("color"));

    template = template.replace("<value>", value);
    template = template.replace("<backgroundColor>", backgroundColor);
    template = template.replace("<textColor>", textColor);

    return template;   
}

/**
 * Erstellt das Eigenschaften-Menü für Checkboxen & Radio-Buttons
 * 
 * @param {string} fieldId 
 * @param {string} template 
 * @returns string
 */

function createBoxesPropertiesMenu(fieldId, template){
    let options = "";
    let label = $("#" + fieldId).find("label.form-label").text();
    
    $("#" + fieldId).find("label.form-check-label").text(function(i, option){
        options += option + "\r\n";
    });
    
    let mandatoryField = $("#" + fieldId).find("span.required").text(); 

    template = template.replace("<label>", label);
    template = template.replace("<options>", options);

    template = checkIfRequired(mandatoryField, template);

    return template;    
}

//#endregion

//#region Update-Functions

/**
 * Updatet die Beschriftung des Formularfeldes. Ausgenommen sind davon Radio-Buttons & Checkboxen.
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateLabel(e, fieldId){
    let field = $("#" + fieldId);
    field.find("label.form-label").text(e.target.value);   
}

/**
 * Updatet die Beschriftung der Radio-Buttons & Checkboxen
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateBoxesLabel(e, fieldId){
    let field = $("#" + fieldId);
    field.find("label.form-label").text(e.target.value); 
}

/**
 * Updatet die Auswahlmöglichkeiten bei Radio-Buttons & Checkboxen
 * 
 * @param {*} e 
 * @param {string} fieldId 
 * @param {string} radioBtnTemplate 
 * @param {string} checkboxTemplate 
 */

function updateOptions(e, fieldId, radioBtnTemplate, checkboxTemplate){
    
    let field = $("#" + fieldId);
    let options = e.target.value.split("\n");

    
    let labels, inputs, template, id, idAsInt, name;
    
    // Leere Array-Elemente löschen
    options = options.filter(function(element){
        return element != '';
    });

    // Richtige Template nach Typ wählen
    if($(field).find(".card-footer .type").text().toLowerCase() == "checkbox"){
        template = checkboxTemplate;
    }else{
        template = radioBtnTemplate;
    }

    $(options).each(function(i, option){
        
        let index = i + 1;

        if($(field).find(".form-group input").length < index){
            // Für den Fall, dass alle Optionen gelöscht werden
            
            if($(field).find(".form-group input").length > 0){
                
                let idPart = $(field).find(".form-group input").attr("id").substr(0, 10);

                idAsInt = parseInt($(field).find(".form-group input").last().attr("data-id")) + 1;
                id = idPart + idAsInt;

                if(idPart != "radiofield"){
                    idPart = $(field).find(".form-group input").attr("id").substr(0, 7);
                    id = idPart + idAsInt;
                }

                name = $(field).find(".form-group input").attr("name");

                localStorage.clear();
            }else{
                id = localStorage.getItem("id");
                idAsInt = localStorage.getItem("idAsInt");;
                name = localStorage.getItem("name");
            }

            template = template.replace("<id>", id);
            template = template.replace("<idAsInt>", idAsInt);
            template = template.replace("<for>", id);
            template = template.replace("<name>", name);
            template = template.replace("<value>", option);
            template = template.replace("<innerText>", option);

            $(field).find(".form-group").append(template);
        }else{
        
            labels  = $(field).find(".form-group label.form-check-label");
            inputs  = $(field).find(".form-group input.form-check-input");

            $(labels).each(function(idx, label){
                if(i === idx){
                    $(label).text(option);   
                }
            }); 

            $(inputs).each(function(idx, input){
                if(i === idx){
                    $(input).attr("value", option);
                }
            }); 
        }          
    });    

    // Löschen der entfernten Optionen aus dem DOM
    $(labels).each(function(i, label){ 
        if($(label).text() != options[i]){
            $(field).find(".form-group .form-check").last().remove();
        }
    });

    

    // Löscht die letzte Option aus dem DOM
    if(options.length == 0){
        id = $(field).find(".form-group input").attr("id");
        idAsInt = $(field).find(".form-group input").attr("data-id");
        name = $(field).find(".form-group input").attr("name"); 

        // Id & Name in den Localstorage speichern, um bei der ersten Templateerstellung auf diese zugreifen zu können. Ansonsten sind keine Id & Name vorhanden.
        localStorage.setItem("id", id);
        localStorage.setItem("idAsInt", idAsInt);
        localStorage.setItem("name", name);

        $(field).find(".form-group .form-check").remove();
    }
    
}

/**
 * Updatet den Wert des Formularfeldes
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateValue(e, fieldId){
    let field = $("#" + fieldId);
    $(field).find("input").attr("value", e.target.value);   
}

/**
 * Updatet die Hintergrundfarbe des Formularfeldes
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateBackgroundColor(e, fieldId){
    let field = $("#" + fieldId);
    $(field).find("input").css("backgroundColor", e.target.value);   
}

/**
 * Updatet die Textfarbe des Formularfeldes
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateTextColor(e, fieldId){
    let field = $("#" + fieldId);
    $(field).find("input").css("color", e.target.value);   
}

/**
 * Updatet die Platzhalter des Formularfeldes
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updatePlaceholder(e, fieldId){
    let field = $("#" + fieldId);

    if(field.find("input").length > 0){
        field.find("input").attr("placeholder", e.target.value);
    }else{
        field.find("textarea").attr("placeholder", e.target.value);
    }
    
}

/**
 * Updatet die Reihen der Textarea
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateRows(e, fieldId){
    let field = $("#" + fieldId);
    field.find("textarea").attr("rows", e.target.value);
}

/**
 * Updatet den Pflichtfeld-Status des Formularfeldes
 * 
 * @param {*} e 
 * @param {string} fieldId 
 */

function updateMandatoryStatus(e, fieldId){
    let field = $("#" + fieldId);

    if(e.target.checked == true){
        field.find("span.required").text("*");
        
        if(field.find(".type").text() != "Checkbox" && field.find(".type").text() != "Radio-Button"){
            
            if(field.find(".type").text() == "Mehrzeiliges Textfeld"){
                field.find("textarea").attr("required", true);
            }else{
                field.find("input").attr("required", true);
            }
            
        }else{
            field.find("input").first().attr("required", true);
        }
        
        e.target.checked = true;
    }else{
        field.find("span.required").text("");

        if(field.find(".type").text() !== "Checkbox" && field.find(".type").text() !== "Radio-Button"){

            if(field.find(".type").text() == "Mehrzeiliges Textfeld"){
                field.find("textarea").attr("required", false);
            }else{
                field.find("input").attr("required", false);
            }

        }else{
            field.find("input").first().attr("required", false);
        }
        
        e.target.checked = false;
    }
    
}

//#endregion

//#region Further Functions

/**
 * Prüft, ob das Formularfeld ein Pflichtfeld ist oder nicht und führt entsprechend daraus Aktionen aus
 * 
 * @param {string} mandatoryField 
 * @param {string} template 
 * @returns string
 */

function checkIfRequired(mandatoryField, template){
    if(mandatoryField == "*"){
        template = template.replace("<checked>", "checked");
    }else{
        template = template.replace("<checked>", "");
    }

    return template;
}


/**
 * Wandelt einen RGB-Farbwert in einen HEX-Farbwert um
 * Code from: https://stackoverflow.com/a/3627747
 * 
 * @param {string} rgb 
 * @returns string
 */
function rgbToHex(rgb){
    return `#${rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/).slice(1).map(n => parseInt(n, 10).toString(16).padStart(2, '0')).join('')}`;
}

//#endregion

export {showPropertiesMenu, hidePropertiesMenu, updateLabel, updatePlaceholder, updateMandatoryStatus, updateRows, updateValue, updateBackgroundColor, updateTextColor,  updateBoxesLabel, updateOptions, radioBtnTemplate, checkboxTemplate};