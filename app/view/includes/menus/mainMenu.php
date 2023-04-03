<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item">
                        <a class="nav-link fs-5 <?php echo $data["activeHome"]; ?>" href="/project/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 <?php echo $data["activeAccount"]; ?>" href="/project/account">Mein Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 <?php echo $data["activeApi"]; ?>" href="/project/api">API</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="/project/logout">Ausloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>