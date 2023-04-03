<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/mainMenu.php"; ?>

<main class="container">
    <?php
        echo $data["action"];
    ?>
    <section class="mt-5 mb-5">
        <h3>Hallo <?php echo htmlspecialchars($data["username"]); ?></h3>
        <p class="fs-5">willkommen in deinem Mitgliederbereich.</p>
        
        <?php echo $data["formHeader"]; ?>

        <div>
            <?php echo $data["formTableLabels"]; ?>
            <?php foreach($data["forms"] as $form) : ?>
                <div class="row border-bottom  mt-3  pe-3">
                    <div class="col-10">
                        <p class="fst-italic fs-5"><?php echo htmlspecialchars($form->name); ?></p>
                    </div>
                    <div class="col-2 d-flex flex-row-reverse mb-3">
                            <div class="btn-group" role="group">
                                <a href="<?php echo htmlspecialchars($form->downloadLink); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Herunterladen" download><i class="fas fa-download"></i></a>
                                <form method="POST" action="/project/form/edit">
                                    <button class="btn btn-warning editForm" name="edit" data-toggle="tooltip" data-placement="top" title="Bearbeiten"><i class="far fa-edit"></i></button>
                                    <input type="hidden" name="formId" value="<?php echo $form->formId; ?>">
                                </form>
                                <form method="POST" action="/project/form/delete">
                                    <button class="btn btn-danger" name="delete" data-toggle="tooltip" data-placement="top" title="Löschen"><i class="far fa-trash-alt"></i></button>
                                    <input type="hidden" name="formId" value="<?php echo $form->formId; ?>">

                                </form>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        
        <a href="form/create" class="btn btn-primary mt-5">Jetzt neues Formular erstellen!</a> 
        
    </section>
    
    
</main>
<?php include "app/view/includes/footer.php"; ?>