<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/goBackMenu.php"; ?>

<main class="container mt-5">
    <h1 class="text-center mb-5">Deine Passwort ändern</h1>
    <section class="w-50 mx-auto">
        <form method="POST">
            <div class="form-group">
                <label for="password">Neues Passwort:</label>
                <input type="password" name="password" id="password" class="form-control" disabled>
            </div>
            <div class="form-group mt-3">
                <label for="passwordRepeat">Neues Passwort wiederholen:</label>
                <input type="password" name="passwordRepeat" id="passwordRepeat" class="form-control" disabled>
            </div>

            <input type="submit" value="Jetzt Passwort ändern!" class="btn btn-primary form-control mt-3" disabled>
        </form>
        <?php echo $data["error"] ?? $data["success"]; ?>
    </section>
</main>

<?php include "app/view/includes/footer.php"; ?>