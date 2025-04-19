<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<div>
    <br>
    <br>
    <h2 class="enigma-gains">Enigma Mode Normal</h2>
    <br>
        <form method="post" action="enigmaNormal"> 
            <div class="enigma-bonus-center">                
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
                            Mauvaise réponse !
                        </div>
                <?php } ?>
                <?php if ($rightAnswer){ ?>
                        <div class="alert alert-success" role="alert">
                            Bravo ! Vous avez gagné 
                            <?php 
                                echo $_SESSION['recompense'] . " caps !";
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