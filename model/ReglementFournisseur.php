<?php
class ReglementFournisseur{
    //attributes
    private $_id;
    private $_dateReglement;
    private $_montant;
    private $_idFournisseur;
	private $_idProjet;
	private $_modePaiement;
	private $_numeroCheque;
    
    //le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    
    //setters
    
    public function setId($id){
        $this->_id = $id;
    } 
    
    public function setDateReglement($dateReglement){
        $this->_dateReglement = $dateReglement;
    }
    
    public function setMontant($montant){
        $this->_montant = $montant;
    }
    
    public function setIdFournisseur($idFournisseur){
        $this->_idFournisseur = $idFournisseur;
    }
	
	public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
	
	public function setModePaiement($modePaiement){
		$this->_modePaiement = $modePaiement;
	}
    
	public function setNumeroCheque($numeroCheque){
		$this->_numeroCheque = $numeroCheque;
	}
	
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function dateReglement(){
        return $this->_dateReglement;
    }
    
    public function montant(){
        return $this->_montant;
    }
    
    public function idFournisseur(){
        return $this->_idFournisseur;
    }
	
	public function idProjet(){
        return $this->_idProjet;
    }
	
	public function modePaiement(){
		return $this->_modePaiement;
	}
	
	public function numeroCheque(){
		return $this->_numeroCheque;
	}
}
