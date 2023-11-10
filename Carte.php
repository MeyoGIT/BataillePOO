<?php

class Carte
{
    private $libelle;

    private $valeur;

    public function __construct($libelle, $valeur)
    {
        $this->libelle = $libelle;
        $this->valeur = $valeur;
    }

    /**
     * Get the value of valeur
     */ 
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set the value of valeur
     *
     * @return  self
     */ 
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get the value of libelle
     */ 
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */ 
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function afficheCarte()
    {
        return $this->getLibelle();;
    }
}

?>
