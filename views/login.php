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
            <?php if (!empty($successMessage)){ ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $successMessage; ?>
                    </div>
                <?php } ?>
                <form method="post">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <?php if ($errorLogin){ ?>
                            <div class="alert alert-danger" role="alert">
                                Mot de passe ou nom de joueur incorrect.
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-primary">Connexion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>