<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<div>
    <h2 class="enigma-gains">Enigma</h2>
    <div>
        <h3 class="enigma-gains">Veuillez choisir votre mode de jeu</h3>
        
        <div class="container-enigma-mode">
            <div class="enigma-mode">
                <a href="/enigmaNormal" class="btn btn-primary">Normal</a>
                <p>Dans ce mode, la question et la difficulté est aléatoire.</p>
                
            </div>
            <div class="enigma-mode">
                <a href="/enigmaBonus" class="btn btn-primary">Bonus</a>
                <p>Dans ce mode, la question est aléatoire, mais la difficulté est votre choix.</p>
                <p>Si vous répondez à 3 questions difficiles de suites un bonus de 1000 caps vous est accordé.</p>
            </div>
        </div>
        <div class="enigma-gains">
            <h3>Récompenses</h3>
            Énigme difficile → 200 caps<br>
            Énigme moyen     → 100 caps<br>
            Énigme facile    → 50 caps
        </div>
    </div>
</div>









<?php require 'partials/footer.php'; ?>