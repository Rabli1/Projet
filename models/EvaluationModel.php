<?php

require_once 'src/class/Evaluation.php';


class EvaluationModel
{
    public function __construct(private PDO $pdo) {}

public function selectAllEvaluationsByIdItem(int $idItem): ?array {
    try {
        $stmt = $this->pdo->prepare('
            SELECT e.idJoueurs, e.idItem, e.evaluation, e.commentaire, j.alias AS joueurAlias
            FROM évaluation e
            JOIN joueurs j ON e.idJoueurs = j.idJoueurs
            WHERE e.idItem = :idItem
        ');
        $stmt->execute(['idItem' => $idItem]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $evaluations[] = [
                    'idJoueurs' => $row['idJoueurs'],
                    'idItem' => $row['idItem'],
                    'evaluation' => $row['evaluation'],
                    'commentaire' => $row['commentaire'],
                    'joueurAlias' => $row['joueurAlias']
                ];
            }
            return $evaluations;
        }
        return null;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

    public function insertEvaluation(int $idJoueurs, int $idItem, int $evaluation, string $commentaire): void {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO évaluation (idJoueurs, idItem, evaluation, commentaire) VALUES (:idJoueurs, :idItem, :evaluation, :commentaire)');
            $stmt->execute([
                'idJoueurs' => $idJoueurs,
                'idItem' => $idItem,
                'evaluation' => $evaluation,
                'commentaire' => $commentaire
            ]);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
    
    public function updateEvaluation(int $idJoueurs, int $idItem, int $evaluation, string $commentaire): void {
        try {
            $stmt = $this->pdo->prepare('UPDATE évaluation SET evaluation = :evaluation, commentaire = :commentaire WHERE idJoueurs = :idJoueurs AND idItem = :idItem');
            $stmt->execute([
                'evaluation' => $evaluation,
                'commentaire' => $commentaire,
                'idJoueurs' => $idJoueurs,
                'idItem' => $idItem
            ]);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function deleteEvaluation(int $idJoueurs, int $idItem): void {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM évaluation WHERE idJoueurs = :idJoueurs AND idItem = :idItem');
            $stmt->execute([
                'idJoueurs' => $idJoueurs,
                'idItem' => $idItem
            ]);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
}