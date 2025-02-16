    <header data-bs-theme="dark">

      <!-- Menu -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Team Gaben</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
              <?php if (isAuthenticated() && !isAdministrator()) {?>
                <li><a class="nav-link" href="/ajouter">Ajouter une publicité</a></li>
                <li><a class="nav-link" href="/gerer-pub">Gérer mes publicités</a></li>
             <?php } ?>
             <?php if (isAuthenticated() && isAdministrator()) { ?>
              <li><a class="nav-link" href="/gerer-client">Gérer les clients</a></li>
             <?php } ?>
            </ul>
            
            <?php if (!isAuthenticated()) { ?>
              <a class="btn btn-primary me-2" role="button" href="/user-creation">Créer un compte</a>
              <a class="btn btn-primary" role="button" href="/connexion">Connexion</a>
            <?php }  
                  else {?>
                    <a class="btn btn-primary" role="button" href="/deconnexion">Déconnexion</a>
                    <?php }?>

          </div>
        </div>
      </nav>

    </header>