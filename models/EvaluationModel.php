<?php

require_once 'src/class/Evaluation.php';


class EvaluationModel
{
    public function __construct(private PDO $pdo) {}

    public function selectAllEvaluationsByIdItem(int $idItem): ?array {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM evaluation WHERE idItem = :idItem');
            $stmt->execute(['idItem' => $idItem]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $evaluations[] = new Evaluation(
                        $row['idJoueurs'],
                        $row['idItem'],
                        $row['evaluation'],
                        $row['commentaire']
                    );
                }
                return $evaluations;
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}