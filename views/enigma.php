<?php
require 'partials/head.php';
require 'partials/enigmaHeader.php';
?>

<div>
    <br>
    <br>
    <h2 class="enigma-gains">Enigma</h2>
    <br>
    <div>
        <h3 class="enigma-gains">Veuillez choisir votre mode de jeu</h3>
        <br>
        <br>
        <div class="container-enigma-mode">
            <div class="enigma-mode">
                <br>
                <div class="dropdown">
                    <a href="/enigmaNormal" class="btn">Normal</a>
                    <div class="dropdown-content">
                        <p>Dans ce mode, la question et la difficulté est aléatoire.</p>
                    </div>
                </div>
                <br>

            </div>
            <div class="enigma-mode">
                <br>
                <div class="dropdown">
                    <a href="/enigmaBonus" class="btn">Bonus</a>
                    <div class="dropdown-content">

                        <p>Dans ce mode, la question est aléatoire, mais la difficulté est votre choix.</p>
                        <p>Si vous répondez à 3 questions difficiles de suites un bonus de 1000 caps vous est accordé.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <br>
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
<br>
<br>
<br>
<br>
<br>
<br>
<?php require 'partials/footer.php'; ?>