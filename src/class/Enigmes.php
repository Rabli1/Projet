<?php
/*
idQuêtes int
description varchar(300)
difficulté char(1)
estPigee tinyint(1)
reponse varchar(300)
*/

class Enigmes {
    private int $idQuêtes;
    private string $description;
    private string $difficulté;
    private int $estPigee;
    private string $reponse;

    public function __construct(int $idQuêtes, string $description, string $difficulté, int $estPiegee, string $reponse) {
        $this->idQuêtes = $idQuêtes;
        $this->description = $description;
        $this->difficulté = $difficulté;
        $this->estPigee = $estPiegee;
        $this->reponse = $reponse;
    }

    // Getters
    public function getIdQuêtes(): int {
        return $this->idQuêtes;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDifficulté(): string {
        return $this->difficulté;
    }

    public function getEstPigee(): int {
        return $this->estPigee;
    }

    public function getReponse(): string {
        return $this->reponse;
    }

    // Setters
    public function setIdQuêtes(int $idQuêtes): void {
        $this->idQuêtes = $idQuêtes;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setDifficulté(string $difficulté): void {
        $this->difficulté = $difficulté;
    }

    public function setEstPigee(int $estPigee): void {
        $this->estPigee = $estPigee;
    }

    public function setReponse(string $reponse): void {
        $this->reponse = $reponse;
    }
}