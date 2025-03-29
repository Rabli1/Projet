<header data-bs-theme="dark">
    <!-- Menu -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/44720d3ccc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/styles.css">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Team Gaben</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Panier d'achat -->
                <?php if(isAuthenticated()) { ?>
                <div class="cart-wrapper me-3">
                    <a class="btn btn-outline-light position-relative" href="/panier" title="Panier d'achat">
                    <i class="bi bi-bag"></i> <!-- Icone du panier -->
                        <?php if (!empty($_SESSION['panier']['nbTotItem'])) { ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $_SESSION['panier']['nbTotItem']; ?>
                            </span>
                        <?php } ?>
                    </a>
                </div>
                <?php } ?>
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <?php if (isAuthenticated() && !isAdministrator()) { ?>
                        <li><a class="nav-link" href="/inventaire">Inventaire</a></li>
                        <li><a class="nav-link" href="/gerer-pub">Gérer mon compte</a></li>
                    <?php } ?>
                    <?php if (isAuthenticated() && isAdministrator()) { ?>
                        <li><a class="nav-link" href="/gerer-client">Gérer les utilisateurs</a></li>
                    <?php } ?>
                </ul>

                <div class="d-flex align-items-center">

                    <!-- Connexion / Création de compte -->
                    <?php if (!isAuthenticated()) { ?>
                        <a class="btn btn-primary me-2" role="button" href="/createAccount">Créer un compte</a>
                        <a class="btn btn-primary" role="button" href="/connexion">Connexion</a>
                    <?php } else { ?>
                        <i><?php echo $_SESSION['username'] ?></i>
                        <a class="btn btn-primary" role="button" href="/deconnexion">Déconnexion</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
</header>
