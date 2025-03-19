<?php

class Joueurs {
    private $idJoueurs;
    private $alias;
    private $nom;
    private $prenom;
    private $montantCaps;
    private $dexterite;
    private $pointDeVie;
    private $poidsMaxTransport;
    private $motDePasse;
    private $estAdmin;

    // Constructor
    public function __construct($idJoueurs, $alias, $nom, $prenom, $montantCaps, $dexterite, $pointDeVie, $poidsMaxTransport, $motDePasse, $estAdmin) {
        $this->idJoueurs = $idJoueurs;
        $this->alias = $alias;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->montantCaps = $montantCaps;
        $this->dexterite = $dexterite;
        $this->pointDeVie = $pointDeVie;
        $this->poidsMaxTransport = $poidsMaxTransport;
        $this->motDePasse = $motDePasse;
        $this->estAdmin = $estAdmin;
    }

    // Getters and Setters
    public function getIdJoueur() {
        return $this->idJoueurs;
    }

    public function setIdJoueur($idJoueurs) {
        $this->idJoueurs = $idJoueurs;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getMontantCaps() {
        return $this->montantCaps;
    }

    public function setMontantCaps($montantCaps) {
        $this->montantCaps = $montantCaps;
    }

    public function getDexterite() {
        return $this->dexterite;
    }

    public function setDexterite($dexterite) {
        $this->dexterite = $dexterite;
    }

    public function getPointDeVie() {
        return $this->pointDeVie;
    }

    public function setPointDeVie($pointDeVie) {
        $this->pointDeVie = $pointDeVie;
    }

    public function getPoidsMaxTransport() {
        return $this->poidsMaxTransport;
    }

    public function setPoidsMaxTransport($poidsMaxTransport) {
        $this->poidsMaxTransport = $poidsMaxTransport;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }

    public function getEstAdmin() {
        return $this->estAdmin;
    }

    public function setEstAdmin($estAdmin) {
        $this->estAdmin = $estAdmin;
    }
}
?>