<?php
/*
idItem int PK 
matière varchar(10) 
taille varchar(10)
*/

class Armures
{
    private int $idItem;
    private string $matière;
    private string $taille;

    // Constructor property promotion
    public function __construct(int $idItem, string $matière, string $taille) {
        $this->idItem = $idItem;
        $this->matière = $matière;
        $this->taille = $taille;
    }

    // Getters
    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getMatière(): string {
        return $this->matière;
    }

    public function getTaille(): string {
        return $this->taille;
    }

    // Setters
    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setMatière(string $matière): void {
        $this->matière = $matière;
    }

    public function setTaille(string $taille): void {
        $this->taille = $taille;
    }
}