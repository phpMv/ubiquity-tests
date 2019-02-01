<?php
namespace models;
class Organizationsettings{
	/**
	 * @id
	 * @column("name"=>"idSettings","nullable"=>false,"dbType"=>"int(11)")
	 * @validator("id","constraints"=>array("autoinc"=>true))
	**/
	private $idSettings;

	/**
	 * @id
	 * @column("name"=>"idOrganization","nullable"=>false,"dbType"=>"int(11)")
	 * @validator("id","constraints"=>array("autoinc"=>true))
	**/
	private $idOrganization;

	/**
	 * @column("name"=>"value","nullable"=>true,"dbType"=>"varchar(100)")
	 * @validator("length","constraints"=>array("max"=>100))
	**/
	private $value;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Organization","name"=>"idOrganization","nullable"=>false)
	**/
	private $organization;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Settings","name"=>"idSettings","nullable"=>false)
	**/
	private $settings;

	 public function getIdSettings(){
		return $this->idSettings;
	}

	 public function setIdSettings($idSettings){
		$this->idSettings=$idSettings;
	}

	 public function getIdOrganization(){
		return $this->idOrganization;
	}

	 public function setIdOrganization($idOrganization){
		$this->idOrganization=$idOrganization;
	}

	 public function getValue(){
		return $this->value;
	}

	 public function setValue($value){
		$this->value=$value;
	}

	 public function getOrganization(){
		return $this->organization;
	}

	 public function setOrganization($organization){
		$this->organization=$organization;
	}

	 public function getSettings(){
		return $this->settings;
	}

	 public function setSettings($settings){
		$this->settings=$settings;
	}

	 public function __toString(){
		return $this->idSettings;
	}

}