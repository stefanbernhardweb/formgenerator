"use strict";

/**
 * Erfasse die aktuelle Route
 */

 let actualRoute = window.location.href.split("/");
 actualRoute = "/" + actualRoute[4] + "/" + actualRoute[5];
 

//#region Templates

/**
 * Einheitliches Template der einzelnen Formularfelder im Generator mit Platzhalter
 *      > Platzhalter:
 *          > id
 *          > label
 *          > field
 *          > type
 * 
 *  */ 

const fieldTemplate = `<div class="card mt-2 createdFormField" id="<id>">
                            <div class="card-body">  
                                <div class="form-group">
                                    <label> <span class="required text-danger"></span>
                                    <field>
                                </div>             
                            </div>
                            <div class="card-footer <backgroundColor> d-flex justify-content-between align-items-center">
                                <span class="badge badge-pill type"><type></span>

                                <i class="fas fa-sort-up sortableIcons"></i>
                                <i class="fas fa-sort-down sortableIcons"></i>
                                
                                <button class="btn btn-danger deleteBtn" title="Löschen"><i class="fas fa-trash fa-xs"></i></button>
                            </div>
                        </div>`;
                        


//#endregion

//#region Main-Function

/**
 * Erstellt das gewählte Formularfeld
 * 
 * @param {*} e 
 * @param {function} step4 
 * @returns string
 */

function createChoosenField(e, step4){
    let field = $(e)[0].target;
    let id;
    
    field = $(field).attr("data-type");
    
    // Close Popover
    step4();

    id = createFormField(field, fieldTemplate);
    

    return id;
}
//#endregion

//#region Field-Functions: Create    
    
    let cardId;

    if(actualRoute == "/form/edit"){
        cardId = $(".createdFormField").length;
    }else{
        cardId = 1;
    }

    /**
     * Erfasst, mit dem Typ des zu erstellenden Feldes, die spezifischen Felddaten, ersetzt die Platzhalter im Template durch diese und fügt das fertiggestellte Template in den Formulargenerator ein
     * 
     * @param {string} type 
     * @param {string} template 
     * @returns string
     */

    function createFormField(type, template){
        let fieldData;
        let id = "field" + ++cardId;

        switch(type){
            case "textfeld":
                fieldData = getTextFieldData(id);
                break;
            case "textarea":
                fieldData = getTextAreaData(id);
                break;
            case "email":
                fieldData = getEmailFieldData(id);
                break;
            case "passwort":
                fieldData = getPasswordFieldData(id);
                break;
            case "radio":
                fieldData = getRadioButtonsData(id);
                break;
            case "checkbox":
                fieldData = getCheckboxData(id);
                break;
        }

        template = template.replace("<id>", id);
        template = template.replace("<label>", fieldData[0]);
        template = template.replace("<field>", fieldData[1]);
        template = template.replace("<type>", fieldData[2]);
        template = template.replace("<backgroundColor>", fieldData[3]);

        $("#sortable").append(template);

        return id;
    }

    /**
     * Gibt die spezifischen Daten eines Textfeldes zurück
     * 
     * @param {string} id 
     * @returns array
     */

    function getTextFieldData(id){
        let label = '<label for="text' + id + '" class="form-label">Text</label>';
        let field = '<input type="text" class="form-control" id="text' + id + '" name="text' + id + '" placeholder="Example Text">';
        let type = "Einzeiliges Textfeld";
        let backgroundColor = "bg-primary";
        
        return [label, field, type, backgroundColor];
    }

    /**
     * Gibt die spezifischen Daten einer Textarea zurück
     * 
     * @returns array
     */

    function getTextAreaData(){
        let label = '<label for="textarea' + cardId + '" class="form-label">Example</label>';
        let field = '<textarea name="textarea' + cardId + '" id="textarea' + cardId + '" placeholder="Example..." class="form-control" rows="5"></textarea>';
        let type = "Mehrzeiliges Textfeld";
        let backgroundColor = "bg-secondary";

        return [label, field, type, backgroundColor];
    }

    /**
     * Gibt die spezifischen Daten eines E-Mail-Feldes zurück
     * 
     * @param {string} id 
     * @returns array
     */

    function getEmailFieldData(id){
        let label = '<label for="email' + id + '" class="form-label">E-Mail</label>';
        let field = '<input type="email" class="form-control" id="email' + id + '" name="email' + id + '" placeholder="Ihre E-Mail">';
        let type = "E-Mail";
        let backgroundColor = "bg-success";

        return [label, field, type, backgroundColor];
    }

     /**
     * Gibt die spezifischen Daten eines Passwort-Feldes zurück
     * 
     * @param {string} id 
     * @returns array
     */

    function getPasswordFieldData(id){
        let label = '<label for="password' + id + '" class="form-label">Passwort</label>';
        let field = '<input type="password" class="form-control" id="password' + id + '" name="password' + id + '" placeholder="Ihr Passwort">';
        let type = "Passwort";
        let backgroundColor = "bg-warning";

        return [label, field, type, backgroundColor];
    }

    /**
     * Gibt die spezifischen Daten eines Radio-Button-Feldes zurück
     * 
     * @param {string} id 
     * @returns array
     */

    function getRadioButtonsData(id){
        let label = '<label for="radiobutton' + id + '" class="form-label">Example</label>';
        let field = `<div class="form-check">
                        <input class="form-check-input" type="radio" value="exampleOne" name="radio` + id + `" id="radio` + id + `" data-id="` + cardId + `">
                        <label class="form-check-label" for="radio` + id + `">exampleOne</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="exampleTwo" name="radio` + id  + `" id="radiofield` + ++cardId + `" data-id="` + cardId + `">
                        <label class="form-check-label" for="radiofield` + ++cardId + `">exampleTwo</label>
                    </div>`;
        let type = "Radio-Button";
        let backgroundColor = "bg-info";
        

        return [label, field, type, backgroundColor];
    }

    /**
     * Gibt die spezifischen Daten eines Checkbox-Feldes zurück
     * 
     * @param {string} id 
     * @returns array
     */

    function getCheckboxData(id){ 
        let label = '<label for="checkbox' + id + '" class="form-label">Example</label>';
        let field = `<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="exampleOne" name="checkbox` + id + `[]" id="cb` + id + `" data-id="` + cardId + `">
                        <label class="form-check-label" for="cb` + id + `">exampleOne</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="exampleTwo" name="checkbox` + id + `[]" id="cbfield` + ++cardId + `" data-id="` + cardId + `">
                        <label class="form-check-label" for="cbfield` + ++cardId + `">exampleTwo</label>
                    </div>`;
        let type = "Checkbox"; 
        let backgroundColor = "bg-dark";              

        return [label, field, type, backgroundColor];
    }

//#endregion

//#region Field-Functions: Getter & Setter and Delete

    /**
     * Löscht das zu löschende Formularfeld und schließt das Eigenschaften-Menü
     * 
     * @param {*} e 
     * @param {function} hidePropertiesMenu 
     */

    function deleteFormField(e, hidePropertiesMenu){
        let field = $(e)[0].currentTarget;
        let card = $(field)[0].parentNode.parentNode;
        
        hidePropertiesMenu(e, setSelectedField);
        card.remove();    
    }

    let selectedCard = 0;

    /**
     * Erfasst das aktuell gewählte Formularfeld und markiert es mit seiner eigenen Farbe
     * 
     * @param {*} e 
     * @param {string} formField 
     * @param {function} getColorCode 
     */

    function setSelectedField(e, formField, getColorCode){

        let field, newCard;

        if(e){
            field = $(e)[0].currentTarget;
        }else{
            field = $(formField)[0];
        }
        
        newCard = $(field).attr("id");

        if(newCard != selectedCard){   
            highlightSelectedField(field, selectedCard, getColorCode);
            selectedCard = newCard;
        }
    }

    /**
     * Erfasst das aktuell ausgewählte Formularfeld und gibt seinen Typ zurück
     * 
     * @param {*} e 
     * @param {string} formField 
     * @returns string
     */
    function getSelectedField(e, formField){
        let field, type;

        // Erfasse Typ wenn das Formularfeld angeklickt worden ist
        if(e){
            field = $(e)[0].currentTarget;  
        }else{
            // Erfasse den Typ wenn das Formularfeld erstellt wird
            field = $(formField)[0];  
        }   

       
        if($(field).find(".type")[0] != undefined){
            type = $(field).find(".type")[0].innerText;
        }
         
        return type;    
    }

//#endregion

//#region Further Functions

/**
 * Aktiviert & setzt die Infopopups für die einzelnen Felder & Eigenschaften im Eigenschaftenmenü
*/

function setInfoPopup(){
    $('[data-toggle="popover"]').popover({
        container: 'body',
        placement: "top",
        trigger: "hover",
        html: true,
        content: function(){
            let actualInfoField = $(this).attr("value");
            let tooltipContent;

            switch(actualInfoField){
                case "textfeld":
                    tooltipContent = "Das einzeilige Textfeld ist für kurze & einzeilige Text-Angaben geeignet.";
                    break;
                case "textarea":
                    tooltipContent = "Das mehrzeilige Textfeld ist für größere & mehrzeilige Text-Angaben geeignet.";
                    break;
                case "email":
                    tooltipContent = "Das E-Mail-Feld ist für die Eingabe von E-Mails geeignet. In diesem wird automatisch geprüft, ob die einge-gebene E-Mail auch eine E-Mail ist oder nicht.";
                    break;
                case "passwort":
                    tooltipContent = "Das Passwort-Feld ist für die Eingabe von Passwörtern geeignet.";
                    break;
                case "radio":
                    tooltipContent = "Das Radio-Button Feld ist für die spezifische Auswahl einer Auswahl-möglichkeit geeignet. Dabei kannst du mehrere Auswahlmöglichkeiten festlegen von denen jedoch nur eine Auswahlmöglichkeit ausgewählt werden kann.";
                    break;
                case "checkbox":
                    tooltipContent = "Das Checkbox-Feld ist für die Mehrfachauswahl von Auswahl-möglichkeiten geeignet. Dabei kannst du mehrere Auswahlmöglichkeiten festlegen von denen mehrere ausgewählt werden können";
                    break;
                case "label":
                    tooltipContent = "Mit der Bezeichnung kannst du die Beschreibung des jeweiligen Formularfeldes festlegen.";
                    break;
                case "placeholder":
                    tooltipContent = "Der Platzhalter ist dafür da um eine Beispielangabe auf das gewählte Formularfeld zu setzen. Diese verschwindet wieder, sobald ein Zeichen im Eingabefeld des Formularfeldes steht.";
                    break;
                case "mandatoryField":
                    tooltipContent = "Mit der Aktivierung des Pflichtfeldes legst du fest, welches Formularfeld unbedingt ausgefüllt werden muss.";
                    break;
                case "rows":
                    tooltipContent = "Mit dieser Einstellung kannst du die größe des mehrzeiligen Textfeldes bestimmen. Gebe hierfür Ganzzahlen ein.";
                    break;
                case "options":
                    tooltipContent = "Über die Optionen kannst du die möglichen Auswahlmöglichkeiten für dieses Formularfeld festlegen.";
                    break;
                case "value":
                    tooltipContent = "Mit dieser Einstellung legst du den Text fest, der im Absende-Button stehen soll.";
                    break;
                case "backgroundColor":
                    tooltipContent = "Mit dieser Einstellung kannst du die Hintergrundfarbe des Absende-Buttons festlegen";
                    break;
                case "textcolor":
                    tooltipContent = "Mit dieser Einstellung kannst du die Textfarbe des Absende-Buttons festlegen";
                    break;
            }

            return tooltipContent;
        }
    });

}

let colorCode;

/**
 * Hebt das zur Zeit ausgewählte Formularfeld in seinen Farben hervor
 * 
 * @param {string} field 
 * @param {string} selectedCard 
 * @param {function} getColorCode 
 */

function highlightSelectedField(field, selectedCard, getColorCode){
   
    let cardBefore = $("#" + selectedCard);
    let backgroundClass;
    
    if(cardBefore){
        cardBefore.css("border", "1px solid rgba(0, 0, 0, 0.125)");
        cardBefore.css("box-shadow", "none");
    }
    
    if($(field).find(".card-footer").length > 0){
        backgroundClass = $(field).find(".card-footer").attr("class").split(" ");
        colorCode = getColorCode(backgroundClass[1]);
        
        $(field).css("border", colorCode[0]);
        $(field).css("box-shadow", colorCode[1]);
    }
}

/**
 * Markiert im Felderauswahlmenü das gerade gehoverte Formularfeld 
 * 
 * @param {*} e 
 * @param {function} getColorCode 
 */

function highlightHoveredField(e, getColorCode){
    let hoveredField = $(e.currentTarget);

    if(getColorCode){
        let backgroundClass = hoveredField.attr("data-bg");
        let colors = getColorCode(backgroundClass);
        hoveredField.css("background-color", colors[2]);
    }else{
        hoveredField.css("background-color", "white");
    }

}

//#endregion

export {createChoosenField, deleteFormField, setSelectedField, getSelectedField, setInfoPopup, highlightHoveredField, colorCode};