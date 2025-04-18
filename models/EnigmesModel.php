<?php

require_once 'src/class/Enigmes.php';

class EnigmesModel{

    public function __construct(private PDO $pdo) {}

    public function getRandomEnigme(): ?Enigmes {
        $query = $this->pdo->query("SELECT * FROM enigmes ORDER BY RAND() LIMIT 1");
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Enigmes(
                $result['idQuêtes'],
                $result['description'],
                $result['difficulté'],
                $result['estPigee'],
                $result['reponse']
            );
        }

        return null; 
    }

    public function getRandomEnigmeByDifficulty(string $difficulty): ?Enigmes {
        $query = $this->pdo->prepare("SELECT * FROM enigmes WHERE difficulté = :difficulty ORDER BY RAND() LIMIT 1");
        $query->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Enigmes(
                $result['idQuêtes'],
                $result['description'],
                $result['difficulté'],
                $result['estPigee'],
                $result['reponse']
            );
        }

        return null; 
    }

}
