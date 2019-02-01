<?php
namespace models;
class Organization{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>false,"dbType"=>"int(11)")
	 * @validator("id","constraints"=>array("autoinc"=>true))
	**/
	private $id;

	/**
	 * @column("name"=>"name","nullable"=>false,"dbType"=>"varchar(100)")
	 * @validator("length","constraints"=>array("max"=>100,"notNull"=>true))
	**/
	private $name;

	/**
	 * @column("name"=>"domain","nullable"=>false,"dbType"=>"varchar(255)")
	 * @validator("length","constraints"=>array("max"=>255,"notNull"=>true))
	**/
	private $domain;

	/**
	 * @column("name"=>"aliases","nullable"=>true,"dbType"=>"text")
	**/
	private $aliases;

	/**
	 * @oneToMany("mappedBy"=>"organization","className"=>"models\\Groupe")
	**/
	private $groupes;

	/**
	 * @oneToMany("mappedBy"=>"organization","className"=>"models\\Organizationsettings")
	**/
	private $organizationsettingss;

	/**
	 * @oneToMany("mappedBy"=>"organization","className"=>"models\\User")
	**/
	private $users;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getName(){
		return $this->name;
	}

	 public function setName($name){
		$this->name=$name;
	}

	 public function getDomain(){
		return $this->domain;
	}

	 public function setDomain($domain){
		$this->domain=$domain;
	}

	 public function getAliases(){
		return $this->aliases;
	}

	 public function setAliases($aliases){
		$this->aliases=$aliases;
	}

	 public function getGroupes(){
		return $this->groupes;
	}

	 public function setGroupes($groupes){
		$this->groupes=$groupes;
	}

	 public function getOrganizationsettingss(){
		return $this->organizationsettingss;
	}

	 public function setOrganizationsettingss($organizationsettingss){
		$this->organizationsettingss=$organizationsettingss;
	}

	 public function getUsers(){
		return $this->users;
	}

	 public function setUsers($users){
		$this->users=$users;
	}

	 public function __toString(){
		return $this->domain;
	}

}