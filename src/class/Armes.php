<?php
/*
idItem int PK 
efficacité int 
typeArmes varchar(20) 
description varchar(50) 
calibre varchar(20)
*/

class Armes
{
    private int $idItem;
    private int $efficacité;
    private string $typeArmes;
    private string $description;
    private string $calibre;

    // Constructor property promotion
    public function __construct(int $idItem, int $efficacité, string $typeArmes, string $description, string $calibre) {
        $this->idItem = $idItem;
        $this->efficacité = $efficacité;
        $this->typeArmes = $typeArmes;
        $this->description = $description;
        $this->calibre = $calibre;
    }

    // Getters
    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getEfficacité(): int {
        return $this->efficacité;
    }

    public function getTypeArmes(): string {
        return $this->typeArmes;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCalibre(): string {
        return $this->calibre;
    }

    // Setters
    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setEfficacité(int $efficacité): void {
        $this->efficacité = $efficacité;
    }

    public function setTypeArmes(string $typeArmes): void {
        $this->typeArmes = $typeArmes;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setCalibre(string $calibre): void {
        $this->calibre = $calibre;
    }
}