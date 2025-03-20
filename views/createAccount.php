<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mt-5">Login</h2>
                <form method="post">
                    <div class="form-group">
                            <label for="firstName">Prénom</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Nom</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Nom de joueur</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordConfirm">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" required>
                        </div>
                        <?php if ($errorMotDePasse){ ?>
                        <div class="alert alert-danger" role="alert">
                            Les mots de passe ne correspondent pas.
                        </div><?php } ?>
                        <button type="submit" class="btn btn-primary">Confirmer</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>    
</body>
</html>