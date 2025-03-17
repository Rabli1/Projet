<?php
/*
calibre varchar(20) 
idItem int PK
*/

class Munitions
{
    private int $idItem;
    private string $calibre;

    // Constructor property promotion
    public function __construct(int $idItem, string $calibre) {
        $this->idItem = $idItem;
        $this->calibre = $calibre;
    }

    // Getters
    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getCalibre(): string {
        return $this->calibre;
    }

    // Setters
    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setCalibre(string $calibre): void {
        $this->calibre = $calibre;
    }
}