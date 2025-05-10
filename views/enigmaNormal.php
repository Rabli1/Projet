<?php
require 'partials/head.php';
require 'partials/enigmaHeader.php';
?>

<div>
    <br>
    <br>
    <h2 class="enigma-gains">Enigma Mode Normal</h2>
    <br>
    <form method="post" action="enigmaNormal">
        <div class="enigma-bonus-center">
            <input type="submit" name="getQuestion" value="Obtenir une question" class="btn boutonQuestion" <?php if (!$activateGetQuestion) {
                echo 'disabled';
            } ?>>
        </div>
        <br>
        <br>
        <div class="enigma-question">
            <?php echo $question ?>
            <br>
            <br>
            <?php
            if ($difficulty == 'f') {
                echo "Difficulté de la question : Facile";
            }
            else if ($difficulty == 'm') {
                echo "Difficulté de la question : Moyenne";
            }
            else if ($difficulty == 'd') {
                echo "Difficulté de la question : Difficile";
            }
            ?>
        </div>
        <br>
        <br>
        <div class="enigma-bonus-center">
            <label for="answer">Entrez votre réponse : </label>
            <input type="text" name="answer" id="answer" placeholder="Réponse">
            <input type="submit" name="validate" value="Valider" class="btn boutonQuestion" <?php if (!$activateValidate) {
                echo 'disabled';
            } ?>>
            <?php if ($wrongAnswer) { ?>
                <div class="alert reponse" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    Mauvaise réponse ! Vous avez perdu <?php echo $_SESSION['hpLoss'] ?> points de vie.
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            <?php } ?>
            <?php if ($rightAnswer) { ?>
                <div class="alert reponse" role="alert">
                    <i class="bi bi-hand-thumbs-up"></i>
                    Bravo ! Vous avez gagné
                    <?php
                    echo $_SESSION['recompense'] . " caps !";
                    ?>
                    <i class="bi bi-hand-thumbs-up"></i>
                </div>
            <?php } ?>
        </div>
    </form>
    <br>
    <div class="enigma-gains">
        <h3>Récompenses</h3>
        Énigme difficile → 200 caps<br>
        Énigme moyen → 100 caps<br>
        Énigme facile → 50 caps
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