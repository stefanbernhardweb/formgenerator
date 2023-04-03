<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/goBackMenu.php"; ?>

<main class="container">
    <h1 class="text-center mb-5 mt-3">Formulargenerator</h1>
    <section class="">
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6" id="formNameContainer">
                <p>Formularname: <span id="formName"><?php echo $data["name"]; ?></span> <i class="fas fa-edit editableIcons" id="formNameEdit"></i> <i class="far fa-times-circle editableIcons" id="formNameEditClose"></i></p>
            </div>
            <div class="col-3 d-flex flex-row-reverse">
                <p><i class="fas fa-cog editableIcons" id="editFurtherSettings"  data-toggle="modal" data-target="#furtherSettings"></i></p>
            </div>
            

            <!-- Modal -->
            <div class="modal fade" id="furtherSettings" tabindex="-1" role="dialog" aria-labelledby="furtherSettings" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Weitere Einstellungen</h5>
                            <i class="fas fa-times close" title="Schließen"></i>
                            
                           
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="furtherSettingsForm">
                                <div class="form-group mb-3">
                                    <p>Wer soll die Anfrage über das Formular erhalten? Tragen Sie diese E-Mail bitte in das untenstehende Textfeld ein?</p>
                                    <label for="receiver">Empfänger-Email</label>
                                    <input type="email" name="receiver" id="receiver" class="form-control" value="<?php echo $data["receiver"]; ?>">
                                </div>
                                <input type="submit" value="Jetzt speichern!" class="btn btn-primary form-control" id="saveFurtherSettings">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </section>
    <section class="">
        <div class="row">
            <div class="col-3">
                <ul class="list-group rounded-0 position-fixed" id="aviableFormFields">
                    <li class="list-group-item active text-center">Formularfelder</li>
                    <li class="list-group-item formField" data-type="textfeld" data-bg="bg-primary"> <i class="fas fa-info-circle text-primary" value="textfeld" data-toggle="popover"  title="Einzeiliges Textfeld"></i> Einzeiliges Textfeld</li>
                    <li class="list-group-item formField" data-type="textarea" data-bg="bg-secondary"> <i class="fas fa-info-circle text-primary" value="textarea" data-toggle="popover"  title="Mehrzeiliges Textfeld"></i> Mehrzeiliges Textfeld</li>
                    <li class="list-group-item formField" data-type="email" data-bg="bg-success"> <i class="fas fa-info-circle text-primary" value="email" data-toggle="popover"  title="E-Mail"> </i> E-Mail</li>
                    <li class="list-group-item formField" data-type="passwort" data-bg="bg-warning"> <i class="fas fa-info-circle text-primary" value="passwort" data-toggle="popover"  title="Passwort"></i> Passwort</li>
                    <li class="list-group-item formField" data-type="radio" data-bg="bg-info"> <i class="fas fa-info-circle text-primary" value="radio" data-toggle="popover"  title="Radio-Button"></i> Radio-Button</li>
                    <li class="list-group-item formField" data-type="checkbox" data-bg="bg-dark"> <i class="fas fa-info-circle text-primary" value="checkbox" data-toggle="popover"  title="Checkbox"></i> Checkbox</li>
                </ul>

                <div class="border position-fixed" id="propertiesMenu">
                
                </div>
            </div>
            <div class="col-9 border p-3" id="formContainer">
                <div id="sortable">
                    <?php echo $data["form"]; ?>
                </div>
                <?php echo $data["submitButton"]; ?>
            </div>
        </div>
        <div class="row">
        <div class="col-3"></div>
            <div class="col-9">
               <p id="output" class="text-danger text-center mt-3"></p>
            </div>
            <div class="col-12 d-flex flex-row-reverse m-0 p-0">
                <input type="hidden" id="formId" value="<?php echo $data['formId']; ?>">
                <button class="btn btn-primary mt-4" id="safeForm">Formular jetzt speichern!</button>
            </div>
        </div>
        
    </section>
    
</main>  

<?php include "app/view/includes/footer.php"; ?>