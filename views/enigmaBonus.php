<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<div>
    <br>
    <br>
    <h2 class="enigma-gains">Enigma Mode Bonus</h2>
    <br>
    <h4 class="enigma-gains">Nombre de bonnes réponses consécutive : <?php echo isset($_SESSION['goodAnswers']) ? $_SESSION['goodAnswers'] : 0; ?></h4>  
    <br>
        <form method="post" action="enigmaBonus"> 
            <div class="enigma-bonus-center">
                <label for="difficulty">Choisissez la difficulté :</label>
                <select name="difficulty" id="difficulty" value="<?php echo $_SESSION['difficulty'] ?>" required <?php if(!$activateSelect) { echo 'disabled'; } ?>>
                    <option value="facile" <?php echo (isset($_SESSION['difficulty']) && $_SESSION['difficulty'] === 'f') ? 'selected' : ''; ?>>Facile</option>
                    <option value="moyen" <?php echo (isset($_SESSION['difficulty']) && $_SESSION['difficulty'] === 'm') ? 'selected' : ''; ?>>Moyen</option>
                    <option value="difficile" <?php echo (isset($_SESSION['difficulty']) && $_SESSION['difficulty'] === 'd') ? 'selected' : ''; ?>>Difficile</option>
                </select>                    
                <input type="submit" name="getQuestion" value="Obtenir une question" class="btn btn-primary" <?php if(!$activateGetQuestion) { echo 'disabled'; } ?>>
            </div>
            <br>
            <br>
            <h3 class="enigma-question"><?php echo $question ?></h3>
            <div class="enigma-bonus-center">
                <label for="answer">Entrez votre réponse : </label>
                <input type="text" name="answer" id="answer" placeholder="Réponse">
                <input type="submit" name="validate" value="Valider" class="btn btn-primary" <?php if(!$activateValidate) { echo 'disabled'; } ?>>
                <?php if ($wrongAnswer){ ?>
                        <div class="alert alert-danger" role="alert">
                            Mot de passe ou nom de joueur incorrect.
                        </div>
                <?php } ?>
                <?php if ($rightAnswer){ ?>
                        <div class="alert alert-success" role="alert">
                            Bravo ! Vous avez gagné 
                            <?php 
                                if (isset($_SESSION['goodAnswers']) && $_SESSION['goodAnswers'] == 0) { 
                                    echo "1200 caps !"; 
                                } else { 
                                    echo $_SESSION['recompense'] . " caps !"; 
                                } 
                            ?>                        
                        </div>
                <?php } ?>
            </div>
        </form>
        <br>
        <div class="enigma-gains">
            <h3>Récompenses</h3>
            Énigme difficile → 200 caps<br>
            Énigme moyen     → 100 caps<br>
            Énigme facile    → 50 caps
        </div>
    </div>
</div>
<br>
<br>
<br>
<br> 
<br>
<br>
<?php require 'partials/footer.php'; ?>