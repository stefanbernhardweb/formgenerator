<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/goBackMenu.php"; ?>

<main class="container mt-5">
    <h1 class="text-center mb-5">Deine E-Mail-Adresse ändern</h1>
    <section class="w-50 mx-auto">      
        <form method="POST">
            <div class="form-group">
                <label for="email">Neue E-Mail-Adresse:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <input type="submit" value="Jetzt E-Mail-Adresse ändern!" class="btn btn-primary form-control mt-3">
        </form>
        <?php echo $data["error"] ?? $data["success"]; ?>
    </section> 
</main>  

<?php include "app/view/includes/footer.php"; ?>