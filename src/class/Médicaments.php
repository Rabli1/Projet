<?php
/*
effet varchar(50) 
duréeEffet int 
effetIndésirable varchar(100) 
Items_idItem int PK 
ptsVie int
*/

class Médicaments
{
    private int $idItem;
    private string $duréeEffet;
    private string $effetIndésirable;
    private int $ptsVie;
    private string $effet;

    // Constructor property promotion
    public function __construct(int $idItem, string $duréeEffet, string $effetIndésirable, int $ptsVie, string $effet) {
        $this->idItem = $idItem;
        $this->duréeEffet = $duréeEffet;
        $this->effetIndésirable = $effetIndésirable;
        $this->ptsVie = $ptsVie;
        $this->effet = $effet;
    }

    // Getters
    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getDuréeEffet(): string {
        return $this->duréeEffet;
    }

    public function getEffetIndésirable(): string {
        return $this->effetIndésirable;
    }

    public function getPtsVie(): int {
        return $this->ptsVie;
    }

    public function getEffet(): string {
        return $this->effet;
    }

    // Setters
    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setDuréeEffet(string $duréeEffet): void {
        $this->duréeEffet = $duréeEffet;
    }

    public function setEffetIndésirable(string $effetIndésirable): void {
        $this->effetIndésirable = $effetIndésirable;
    }

    public function setPtsVie(int $ptsVie): void {
        $this->ptsVie = $ptsVie;
    }

    public function setEffet(string $effet): void {
        $this->effet = $effet;
    }
}