<?php include "includes/header.php"; ?>

<main class="container mt-5 ">
    <?php echo $data["success"]; ?>
    <h1 class="text-center mb-5">Herzlich Willkommen</h1>
    <section class="w-50 mx-auto">
        <ul class="list-unstyled">
            <li class="mb-3"><a href="./login" class="btn btn-primary form-control">Login</a></li>
            <li class="mb-3"><a href="./register" class="btn btn-primary form-control">Registrieren</a></li>
            <li class=""><a href="./form/create" class="btn btn-primary form-control">Jetzt neues Formular zusammenstellen</a></li>
        </ul>
    </section>
</main>

<?php include "includes/footer.php"; ?>

