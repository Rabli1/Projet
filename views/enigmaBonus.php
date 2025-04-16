<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<div>
    <br>
    <br>
    <h2 class="enigma-gains">Enigma Mode Bonus</h2>
    <br>
        <h3 class="enigma-question">La question</h3>
        <br>
        <br>
        <form method="post" > 
            <div class="enigma-bonus-center">
                <label for="difficulty">Choisissez la difficulté :</label>
                <select name="difficulty" id="difficulty" required>
                    <option value="facile">Facile</option>
                    <option value="moyen">Moyen</option>
                    <option value="difficile">Difficile</option>
                </select>         
            <input type="text" name="answer" placeholder="Réponse" required>
            <input type="submit" value="Valider" class="btn btn-primary">
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