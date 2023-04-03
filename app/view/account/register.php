<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/goBackMenu.php"; ?>

<main class="container mt-5">
    <h1 class="text-center mb-5">Registration</h1>
    <section class="w-50 mx-auto">
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="email">E-Mail:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="password">Passwort:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="passwordRepeat">Passwort wiederholen:</label>
                <input type="password" name="passwordRepeat" id="passwordRepeat" class="form-control">
            </div>

            <input type="submit" name="register" value="Jetzt registrieren!" class="btn btn-primary form-control">
        </form>
        
        <?php echo $data["error"] ?? $data["success"]; ?>
        
    </section>
</main>


<?php include "app/view/includes/footer.php"; ?>