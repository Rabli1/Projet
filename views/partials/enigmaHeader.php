<header data-bs-theme="dark">
    <!-- Menu -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/44720d3ccc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/stylesEnigma.css">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Team Gaben</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li><a class="nav-link" href="/enigma">Enigma</a></li>
                </ul>
                <div class="d-flex align-items-center ms-auto">
                    <?php if (isAuthenticated()) { ?>
                        <span class="navbar-text me-3">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                        <span class="navbar-text me-3">
                            <i class="fas fa-coins"></i> <!-- Icone des caps -->
                            <?php echo $_SESSION['montantCaps']; ?> caps
                        </span>
                    <?php } ?>
                    <?php if (isAuthenticated() && isAdministrator()) { ?>
                        <div class="admin-panel-wrapper me-3">
                            <a class="btn btn-outline-light" href="/adminPanel" title="Admin Panel">
                                <i class="bi bi-shield-lock"></i> <!-- Icone du panneau admin -->
                            </a>
                        </div>
                    <?php } ?>
                    <!-- Connexion / Déconnexion -->
                    <?php if (!isAuthenticated()) { ?>
                        <a class="btn btn-primary me-2" role="button" href="/createAccount">Créer un compte</a>
                        <a class="btn btn-primary" role="button" href="/connexion">Connexion</a>
                    <?php } else { ?>
                        <a class="btn btn-success" role="button" href="/deconnexion">Déconnexion</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
</header>
<br>