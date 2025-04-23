<?php

class Backpack {
    private $idJoueurs;
    private $idItems;
    private $qteItems;
    private $poidsTotal;

    public function __construct($idJoueurs, $idItems, $qteItems, $poidsTotal) {
        $this->idJoueurs = $idJoueurs;
        $this->idItem = $idItems;
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
        return $this->idItems;
    }

    public function setIdItem($idItems) {
        $this->idItems = $idItems;
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