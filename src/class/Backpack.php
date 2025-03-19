<?php

class Backpack {
    private $idJoueurs;
    private $idItem;
    private $qteItems;
    private $poidsTotal;

    public function __construct($idJoueurs, $idItem, $qteItems, $poidsTotal) {
        $this->idJoueurs = $idJoueurs;
        $this->idItem = $idItem;
        $this->qteItems = $qteItems;
        $this->poidsTotal = $poidsTotal;
    }

    public function getIdJoueurs() {
        return $this->idJoueurs;
    }

    public function setIdJoueurs($idJoueurs) {
        $this->idJoueurs = $idJoueurs;
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function setIdItem($idItem) {
        $this->idItem = $idItem;
    }

    public function getQteItems() {
        return $this->qteItems;
    }

    public function setQteItems($qteItems) {
        $this->qteItems = $qteItems;
    }

    public function getPoidsTotal() {
        return $this->poidsTotal;
    }

    public function setPoidsTotal($poidsTotal) {
        $this->poidsTotal = $poidsTotal;
    }
}
?>