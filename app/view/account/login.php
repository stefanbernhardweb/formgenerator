<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/goBackMenu.php"; ?>

<main class="container mt-5">
    <h1 class="text-center mb-5">Login</h1>
    <section class="w-50 mx-auto">      
        <form method="POST">
            <div class="form-group">
                <label for="nameOrEmail">Name oder E-Mail:</label>
                <input type="text" name="nameOrEmail" id="nameOrEmail" class="form-control">
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="password">Passwort:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <input type="submit" name="login" value="Jetzt anmelden!" class="btn btn-primary form-control">
        </form>
        <?php echo $data["error"]; ?>
    </section> 
</main>  

<?php include "app/view/includes/footer.php"; ?>
