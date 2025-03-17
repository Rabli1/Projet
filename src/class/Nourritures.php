<?php
/*
idItem int PK 
apportCalorique int 
composantNutritif varchar(10) 
mineralPrincipal varchar(10) 
ptsVie int
*/

class Nourritures
{
    private int $idItem;
    private int $apportCalorique;
    private string $composantNutritif;
    private string $mineralPrincipal;
    private int $ptsVie;

    // Constructor property promotion
    public function __construct(int $idItem, int $apportCalorique, string $composantNutritif, string $mineralPrincipal, int $ptsVie) {
        $this->idItem = $idItem;
        $this->apportCalorique = $apportCalorique;
        $this->composantNutritif = $composantNutritif;
        $this->mineralPrincipal = $mineralPrincipal;
        $this->ptsVie = $ptsVie;
    }

    // Getters
    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getApportCalorique(): int {
        return $this->apportCalorique;
    }

    public function getComposantNutritif(): string {
        return $this->composantNutritif;
    }

    public function getMineralPrincipal(): string {
        return $this->mineralPrincipal;
    }

    public function getPtsVie(): int {
        return $this->ptsVie;
    }

    // Setters
    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setApportCalorique(int $apportCalorique): void {
        $this->apportCalorique = $apportCalorique;
    }

    public function setComposantNutritif(string $composantNutritif): void {
        $this->composantNutritif = $composantNutritif;
    }

    public function setMineralPrincipal(string $mineralPrincipal): void {
        $this->mineralPrincipal = $mineralPrincipal;
    }

    public function setPtsVie(int $ptsVie): void {
        $this->ptsVie = $ptsVie;
    }
}