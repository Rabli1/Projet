<?php

/*
Table: items
Columns:
idItem int AI PK 
nomItem varchar(45) 
qteStock int 
typeItem char(1) 
prixItem int 
poidsItem int 
utilité int 
photo varchar(100) 
flagDispo tinyint default 1
*/
class Items
{
    private int $idItem;
    private string $nomItem;
    private int $qteStock;
    private string $typeItem;
    private int $prixItem;
    private int $poidsItem;
    private int $utilite;
    private string $photo;
    private int $flagDispo;

    // Constructor property promotion
    public function __construct(int $idItem, string $nomItem, int $qteStock, string $typeItem, int $prixItem, int $poidsItem, int $utilite, string $photo, int $flagDispo) {
        $this->idItem = $idItem;
        $this->nomItem = $nomItem;
        $this->qteStock = $qteStock;
        $this->typeItem = $typeItem;
        $this->prixItem = $prixItem;
        $this->poidsItem = $poidsItem;
        $this->utilite = $utilite;
        $this->photo = $photo;
        $this->flagDispo = $flagDispo;
    }

    // Getters
    public function getIdItem(): int {
        return $this->idItem;
    }

    public function getNomItem(): string {
        return $this->nomItem;
    }

    public function getQteStock(): int {
        return $this->qteStock;
    }

    public function getTypeItem(): string {
        return $this->typeItem;
    }

    public function getPrixItem(): int {
        return $this->prixItem;
    }

    public function getPoidsItem(): int {
        return $this->poidsItem;
    }

    public function getUtilite(): int {
        return $this->utilite;
    }

    public function getPhoto(): string {
        return $this->photo;
    }

    public function getFlagDispo(): int {
        return $this->flagDispo;
    }

    // Setters
    public function setIdItem(int $idItem): void {
        $this->idItem = $idItem;
    }

    public function setNomItem(string $nomItem): void {
        $this->nomItem = $nomItem;
    }

    public function setQteStock(int $qteStock): void {
        $this->qteStock = $qteStock;
    }

    public function setTypeItem(string $typeItem): void {
        $this->typeItem = $typeItem;
    }

    public function setPrixItem(int $prixItem): void {
        $this->prixItem = $prixItem;
    }

    public function setPoidsItem(int $poidsItem): void {
        $this->poidsItem = $poidsItem;
    }

    public function setUtilite(int $utilite): void {
        $this->utilite = $utilite;
    }

    public function setPhoto(string $photo): void {
        $this->photo = $photo;
    }

    public function setFlagDispo(int $flagDispo): void {
        $this->flagDispo = $flagDispo;
    }
}
