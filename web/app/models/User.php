<?php
namespace models;
class User{
	/**
	 * @id
	 * @column("name"=>"id","nullable"=>false,"dbType"=>"int(11)")
	 * @validator("id","constraints"=>array("autoinc"=>true))
	**/
	private $id;

	/**
	 * @column("name"=>"firstname","nullable"=>false,"dbType"=>"varchar(65)")
	 * @validator("length","constraints"=>array("max"=>65,"notNull"=>true))
	**/
	private $firstname;

	/**
	 * @column("name"=>"lastname","nullable"=>false,"dbType"=>"varchar(65)")
	 * @validator("length","constraints"=>array("max"=>65,"notNull"=>true))
	**/
	private $lastname;

	/**
	 * @column("name"=>"email","nullable"=>false,"dbType"=>"varchar(255)")
	 * @validator("email","constraints"=>array("notNull"=>true))
	 * @validator("length","constraints"=>array("max"=>255))
	**/
	private $email;

	/**
	 * @column("name"=>"password","nullable"=>true,"dbType"=>"varchar(255)")
	 * @validator("length","constraints"=>array("max"=>255))
	**/
	private $password;

	/**
	 * @column("name"=>"suspended","nullable"=>true,"dbType"=>"tinyint(1)")
	 * @validator("isBool")
	**/
	private $suspended;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\\Organization","name"=>"idOrganization","nullable"=>false)
	**/
	private $organization;

	/**
	 * @oneToMany("mappedBy"=>"user","className"=>"models\\Connection")
	**/
	private $connections;

	/**
	 * @manyToMany("targetEntity"=>"models\\Groupe","inversedBy"=>"users")
	 * @joinTable("name"=>"groupeusers")
	**/
	private $groupes;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getFirstname(){
		return $this->firstname;
	}

	 public function setFirstname($firstname){
		$this->firstname=$firstname;
	}

	 public function getLastname(){
		return $this->lastname;
	}

	 public function setLastname($lastname){
		$this->lastname=$lastname;
	}

	 public function getEmail(){
		return $this->email;
	}

	 public function setEmail($email){
		$this->email=$email;
	}

	 public function getPassword(){
		return $this->password;
	}

	 public function setPassword($password){
		$this->password=$password;
	}

	 public function getSuspended(){
		return $this->suspended;
	}

	 public function setSuspended($suspended){
		$this->suspended=$suspended;
	}

	 public function getOrganization(){
		return $this->organization;
	}

	 public function setOrganization($organization){
		$this->organization=$organization;
	}

	 public function getConnections(){
		return $this->connections;
	}

	 public function setConnections($connections){
		$this->connections=$connections;
	}

	 public function getGroupes(){
		return $this->groupes;
	}

	 public function setGroupes($groupes){
		$this->groupes=$groupes;
	}

	 public function __toString(){
		return $this->email;
	}

}