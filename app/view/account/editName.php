<?php include "app/view/includes/header.php"; ?>
<?php include "app/view/includes/menus/goBackMenu.php"; ?>

<main class="container mt-5">
    <h1 class="text-center mb-5">Deinen Username ändern</h1>
    <section class="w-50 mx-auto">
        <form method="POST">
            <div class="form-group">
                <label for="name">Neuer Username:</label>
                <input type="text" name="name" id="name" class="form-control" disabled>
            </div>

            <input type="submit" value="Jetzt Name ändern!" class="btn btn-primary form-control mt-3" disabled>
        </form>
        <?php echo $data["error"] ?? $data["success"]; ?>
    </section>
</main>

<?php include "app/view/includes/footer.php"; ?>