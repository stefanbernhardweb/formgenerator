"use strict";

/** Hauptausführungsdatei */

/**
 * Import aller Module für die ganze Funktionalität des Formulargenerators
 */
import * as Start from "./modules/start.js";
import * as Introduction from "./modules/introduction.js";
import * as Settings from "./modules/settings.js";
import * as Color from "./modules/color.js";
import * as Modal from "./modules/modal.js";
import * as Fields from "./modules/fields.js";
import * as PropertiesMenu from "./modules/propertiesFieldMenu.js";
import * as Request from "./modules/request.js";
import * as CodeGenerator from "./modules/generateCode.js";

$(document).ready(function(){

    let fieldType;

    /**
     * Erfasse die aktuelle Route
     */

    let actualRoute = window.location.href.split("/");
    actualRoute = "/" + actualRoute[4] + "/" + actualRoute[5];

    /**
     * Start & Introduction
    */
    
    if(actualRoute == "/form/create"){
        Introduction.step1();
        Start.disableElements();
    }

    Start.setFormContainerSortable();

    $("#formNameEdit").on("click", Start.setFormNameEditable);
    $("#formName").on("keypress", function(e){
        if(Introduction.step == 0 && actualRoute == "/form/create"){
            Start.actionOnClickEnter(e, Introduction.step2);
        }else{
            Start.actionOnClickEnter(e);
        }
        
    });

    $("#formNameEditClose").on("click", function(){

        if(Introduction.step == 0 && actualRoute == "/form/create"){
            Start.setFormNameUneditable(Introduction.step2);
        }else{
            Start.setFormNameUneditable();
        }
        
    }); 

    /** Settings */

    $("#furtherSettingsForm").on("submit", function(e){
        Settings.setReceiverEmail(e, actualRoute, Modal.hideModal, Introduction.step3, Start.enableElementsStep3);
    });

    /** 
     * Modal
     */

    $("#editFurtherSettings").on("click", Modal.showModal);
    $(".close").on("click", function(){
        Modal.hideModal(actualRoute, Introduction.step3, Start.enableElementsStep3);
    });

    /**
     * Fields
     */

    /** Hover-Effekt für die verfügbaren Formularfelder */
    $(".formField").on("mouseover", function(e){
        Fields.highlightHoveredField(e, Color.getColorCode);
    });

    $(".formField").on("mouseout", function(e){
        Fields.highlightHoveredField(e);
    });

    
    Fields.setInfoPopup();
    
    $(".formField").on("click", function(e){
        // Erstellt das gewählte Formularfeld und speichert die Id in fieldId ab
        let fieldId = Fields.createChoosenField(e, Introduction.step4);

        // Kennzeiche das gerade erstellte Formularfeld mit seiner Farbe & lese den Typ für das Anzeigen des Eigenschaftenmenüs ein
        Fields.setSelectedField(null, $("#" + fieldId), Color.getColorCode);
        fieldType = Fields.getSelectedField(null, $("#" + fieldId));
        PropertiesMenu.showPropertiesMenu(e, fieldType, fieldId, Fields.setSelectedField, Fields.colorCode);
        
        // Aktiviere die Popovers auch für das Eigenschaftenmenü der neu erstellten Formularfelder
        Fields.setInfoPopup();

        /** Live Bearbeitungsfunktionen */
        $("#label").on("input", function(e){
            PropertiesMenu.updateLabel(e, fieldId);
        });

        $("#options").on("input", function(e){
            PropertiesMenu.updateOptions(e, fieldId, PropertiesMenu.radioBtnTemplate, PropertiesMenu.checkboxTemplate);
        });

        $("#placeholder").on("input", function(e){
            PropertiesMenu.updatePlaceholder(e, fieldId);
        });

        $("#rows").on("input", function(e){
            PropertiesMenu.updateRows(e, fieldId);
        });
        
        $("#mandatoryField").on("click", function(e){
            PropertiesMenu.updateMandatoryStatus(e, fieldId);
        });

        /** Aktionen, die ausgeführt werden, wenn der Anwender direkt auf ein bestehendes Formularfeld klickt */
        $("#" + fieldId).on("click", function(e){        
            Fields.setSelectedField(e, null, Color.getColorCode);
            fieldType = Fields.getSelectedField(e);
            PropertiesMenu.showPropertiesMenu(e, fieldType, $(this).attr("id") , Fields.setSelectedField, Fields.colorCode);
        
            Fields.setInfoPopup();
            
            $("#label").on("input", function(e){
                PropertiesMenu.updateLabel(e, fieldId);
            });

            $("#options").on("input", function(e){
                PropertiesMenu.updateOptions(e, fieldId, PropertiesMenu.radioBtnTemplate, PropertiesMenu.checkboxTemplate);
            });
    
            $("#placeholder").on("input", function(e){
                PropertiesMenu.updatePlaceholder(e, fieldId);
            });

            $("#rows").on("input", function(e){
                PropertiesMenu.updateRows(e, fieldId);
            });
    
            $("#mandatoryField").on("click", function(e){
                PropertiesMenu.updateMandatoryStatus(e, fieldId);
            });
        });

        
        /** Löscht das Formularfeld und blendet das Eigenschaftenmenü aus */
        $("#"+ fieldId).find(".deleteBtn").on("click", function(e){
            Fields.deleteFormField(e, PropertiesMenu.hidePropertiesMenu);
        });
        
    }); 
    
    /** EventListener für die Edit-Funktion des Formulargenerators */
    if(actualRoute == "/form/edit"){

        $(".createdFormField ").on("click", function(e){
            let fieldId = $(this).attr("id");

            Fields.setSelectedField(e, null, Color.getColorCode);
            fieldType = Fields.getSelectedField(e);
            PropertiesMenu.showPropertiesMenu(e, fieldType, fieldId , Fields.setSelectedField, Fields.colorCode);
            Fields.setInfoPopup();
        
            $("#label").on("input", function(e){
                PropertiesMenu.updateLabel(e, fieldId);
            });


            $("#options").on("input", function(e){
                PropertiesMenu.updateOptions(e, fieldId, PropertiesMenu.radioBtnTemplate, PropertiesMenu.checkboxTemplate);
            });
    
            $("#placeholder").on("input", function(e){
                PropertiesMenu.updatePlaceholder(e, fieldId);
            });

            $("#rows").on("input", function(e){
                PropertiesMenu.updateRows(e, fieldId);
            });
    
            $("#mandatoryField").on("click", function(e){
                PropertiesMenu.updateMandatoryStatus(e, fieldId);
            });

            /** Löscht das Formularfeld und blendet das Eigenschaftenmenü aus */
            $("#"+ fieldId).find(".deleteBtn").on("click", function(e){
                Fields.deleteFormField(e, PropertiesMenu.hidePropertiesMenu);
            });
        });

       
       
    }


    // Aktionen für den statischen Sendebutton
    $("#field1").on("click", function(e){
        let fieldId = $(this).attr("id");

        Fields.setSelectedField(e, null, Color.getColorCode);
        fieldType = Fields.getSelectedField(e);
        PropertiesMenu.showPropertiesMenu(e, fieldType, fieldId, Fields.setSelectedField, Fields.colorCode);
        Fields.setInfoPopup();

        $("#value").on("input", function(e){           
            PropertiesMenu.updateValue(e, fieldId);
        });

        $("#backgroundColor").on("input", function(e){           
            PropertiesMenu.updateBackgroundColor(e, fieldId);
        });

        $("#textColor").on("input", function(e){           
            PropertiesMenu.updateTextColor(e, fieldId);
        });
    });

    // Erfasse die notwendigen Daten und erstelle das Formular über ein HTTP-POST Request
    $("#safeForm").on("click", function(){
        
        let labelEmpty = false;
        
        if($(".form-label").length > 0){

           $(".form-label").each(function(i, label){
                if($(label).text() === ""){
                    labelEmpty = true;
                }
            });

            if(!labelEmpty){
                CodeGenerator.generateHTMLCodeOfForm();
    
                let formName = Settings.getFormName();
                let receiver = Settings.getReceiverEmail();
                let form = CodeGenerator.getHTMLCodeOfForm();
                let formId = $("#formId").val();
                let action;
    
                if(actualRoute == "/form/create"){
                    action = "create";
                }else{
                    action = "update";
                }
    
                Request.executeRequest(formName, receiver, form, formId, action, Start.disableAll);
                
            }else{
                $("#output").text("Die Bezeichnungen der einzelnen Formularfelder sind erforderlich!");
            }
        }else{
            $("#output").text("Der Formulargenerator ist leer!");
        }
        
        
        
    });
     
 });