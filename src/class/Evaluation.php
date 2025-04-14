<?php

/*
Table: évaluation
Columns:
idJoueurs int PK
idItem int PK
evaluation int
commentaire varchar(100)
*/

class Evaluation
{
    private int $idJoueurs;
    private int $idItem;
    private int $evaluation;
    private string $commentaire;

    // Constructor property promotion
    public function __construct(int $idJoueurs, int $idItem, int $evaluation, string $commentaire) {
        $this->idJoueurs = $idJoueurs;
        $this->idItem = $idItem;
        $this->evaluation = $evaluation;
        $this->commentaire = $commentaire;
    }

    // Getters
    public function getIdJoueurs(): int {
        return $this->idJoueurs;
    }

    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getEvaluation(): int {
        return $this->evaluation;
    }

    public function getCommentaire(): string {
        return $this->commentaire;
    }

    // Setters

    public function setIdJoueurs(int $idJoueurs): void {
        $this->idJoueurs = $idJoueurs;
    }

    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setEvaluation(int $evaluation): void {
        $this->evaluation = $evaluation;
    }

    public function setCommentaire(string $commentaire): void {
        $this->commentaire = $commentaire;
    }
}
