<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/mainMenu.php"; ?>

<main class="container">
    <section class="mt-5 mb-5">
        <div class="row">
            <div class="col-12 d-flex flex-row-reverse">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data["id"]); ?>">
                    <button class="btn btn-danger">Account löschen &nbsp;<i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 w-50 mx-auto text-center">
                <h1>Mein Profil</h1>

                <div class="card border-0 mt-3">
                    <i class="fas fa-user fa-7x card-img-top d-inline-block pt-3 pb-3"></i>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0">Dein Name: <strong><?php echo htmlspecialchars($data["username"]); ?></strong></li>
                        <li class="list-group-item border-0">Deine E-Mail: <strong><?php echo htmlspecialchars($data["email"]); ?></strong></li>
                        <li class="list-group-item border-0"><a href="/project/account/edit-name" class="btn btn-primary form-control">Deinen Namen ändern</a></li>
                        <li class="list-group-item border-0"><a href="/project/account/edit-email" class="btn btn-primary form-control">Deine E-Mail ändern</a></li>
                        <li class="list-group-item"><a href="/project/account/edit-password" class="btn btn-primary form-control">Dein Passwort ändern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
    </section>
    


    
</main>
<?php include "app/view/includes/footer.php"; ?>