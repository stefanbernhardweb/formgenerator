<?php include "app/view/includes/header.php"; ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container"> 
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="<?php echo $data["navLink"]; ?>" class="nav-link text-decoration-none fs-5"><?php echo $data["nav-link-text"]; ?></a></li>
            </ul>
        </div>
    </nav>
</header>
<main class="container mt-5">
    <h1 class="text-center mb-5">Impressum</h1>
    <h2>Angaben gem&auml;&szlig; &sect; 5 TMG</h2>
    <p>Stefan Bernhard<br />
    Wichernstra&szlig;e, 1<br />
    69168 Wiesloch
    </p>
    <h2>Kontakt</h2>
    <p>Telefon: &#91;Telefonnummer&#93;<br />
    E-Mail: kontakt@example.de
    </p>
    <p>Quelle: <a href="https://www.e-recht24.de">e-recht24.de</a></p>
</main>
<?php include "app/view/includes/footer.php"; ?>