<?php

class Panier {
    private $idPanier;
    private $idJoueur;
    private $quantiteTotale;
    private $poidsTotal;

    // Constructor
    public function __construct($idPanier, $idJoueur, $quantiteTotale, $poidsTotal) {
        $this->idPanier = $idPanier;
        $this->idJoueur = $idJoueur;
        $this->quantiteTotale = $quantiteTotale;
        $this->poidsTotal = $poidsTotal;
    }

    // Getters and Setters
    public function getIdPanier() {
        return $this->idPanier;
    }

    public function setIdPanier($idPanier) {
        $this->idPanier = $idPanier;
    }

    public function getIdJoueur() {
        return $this->idJoueur;
    }

    public function setIdJoueur($idJoueur) {
        $this->idJoueur = $idJoueur;
    }

    public function getQuantiteTotale() {
        return $this->quantiteTotale;
    }

    public function setQuantiteTotale($quantiteTotale) {
        $this->quantiteTotale = $quantiteTotale;
    }

    public function getPoidsTotal() {
        return $this->poidsTotal;
    }

    public function setPoidsTotal($poidsTotal) {
        $this->poidsTotal = $poidsTotal;
    }
}