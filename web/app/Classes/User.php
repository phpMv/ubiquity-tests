<?php

namespace Classes;

class User {
	private $nom;
	private $prenom;
	
	public function setNom($nom){
		$this->nom=$nom;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function setPrenom($prenom){
		$this->prenom=$prenom;
	}
	
	public function getPrenom(){
		return $this->prenom;
	}
	
	
	public function __toString(){
		return "$this->nom $this->prenom";
	}
}

