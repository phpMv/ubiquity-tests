<?php

namespace Ubiquity\orm\parser;

use Ubiquity\orm\OrmUtils;

/**
 * ManyToManyParser
 * @author jc
 * @version 1.1.0.0
 */
class ManyToManyParser {
	private $table;
	private $member;
	private $joinTable;
	private $myFkField;
	private $fkField;
	private $targetEntity;
	private $targetEntityClass;
	private $targetEntityTable;
	private $myPk;
	private $inversedBy;
	private $pk;
	private $instance;
	private $whereValues;

	public function __construct($instance, $member=null) {
		$this->instance=$instance;
		$this->member=$member;
		$this->whereValues=[];
	}

	public function init($annot=false) {
		$member=$this->member;
		$class=$this->instance;
		if(\is_object($class)){
			$class=get_class($class);
		}
		if($annot===false){
			$annot=OrmUtils::getAnnotationInfoMember($class, "#manyToMany", $member);
		}
		if ($annot !== false) {
			$this->_init($class,$annot);
			return true;
		}
		return false;
	}
	
	private function _init($class,$annot){
		$this->table=OrmUtils::getTableName($class);
		$this->targetEntity=$annot["targetEntity"];
		$this->inversedBy=strtolower($this->targetEntity) . "s";
		if (!is_null($annot["inversedBy"]))
			$this->inversedBy=$annot["inversedBy"];
		$this->targetEntityClass=get_class(new $this->targetEntity());
		
		$annotJoinTable=OrmUtils::getAnnotationInfoMember($class, "#joinTable", $this->member);
		$this->joinTable=$annotJoinTable["name"];
		
		$this->myFkField=OrmUtils::getDefaultFk($class);
		$this->myPk=OrmUtils::getFirstKey($class);
		if(isset($annotJoinTable["joinColumns"])){
			$joinColumnsAnnot=$annotJoinTable["joinColumns"];
			if (!is_null($joinColumnsAnnot)) {
				$this->myFkField=$joinColumnsAnnot["name"];
				$this->myPk=$joinColumnsAnnot["referencedColumnName"];
			}
		}
		$this->targetEntityTable=OrmUtils::getTableName($this->targetEntity);
		$this->fkField=OrmUtils::getDefaultFk($this->targetEntityClass);
		$this->pk=OrmUtils::getFirstKey($this->targetEntityClass);
		if(isset($annotJoinTable["inverseJoinColumns"])){
			$inverseJoinColumnsAnnot=$annotJoinTable["inverseJoinColumns"];
			if (!is_null($inverseJoinColumnsAnnot)) {
				$this->fkField=$inverseJoinColumnsAnnot["name"];
				$this->pk=$inverseJoinColumnsAnnot["referencedColumnName"];
			}
		}
	}

	public function getMember() {
		return $this->member;
	}

	public function setMember($member) {
		$this->member=$member;
		return $this;
	}

	public function getJoinTable() {
		return $this->joinTable;
	}

	public function setJoinTable($joinTable) {
		$this->joinTable=$joinTable;
		return $this;
	}

	public function getMyFkField() {
		return $this->myFkField;
	}

	public function setMyFkField($myFkField) {
		$this->myFkField=$myFkField;
		return $this;
	}

	public function getFkField() {
		return $this->fkField;
	}

	public function setFkField($fkField) {
		$this->fkField=$fkField;
		return $this;
	}

	public function getTargetEntity() {
		return $this->targetEntity;
	}

	public function setTargetEntity($targetEntity) {
		$this->targetEntity=$targetEntity;
		return $this;
	}

	public function getTargetEntityClass() {
		return $this->targetEntityClass;
	}

	public function setTargetEntityClass($targetEntityClass) {
		$this->targetEntityClass=$targetEntityClass;
		return $this;
	}

	public function getTargetEntityTable() {
		return $this->targetEntityTable;
	}

	public function setTargetEntityTable($targetEntityTable) {
		$this->targetEntityTable=$targetEntityTable;
		return $this;
	}

	public function getMyPk() {
		return $this->myPk;
	}

	public function setMyPk($myPk) {
		$this->myPk=$myPk;
		return $this;
	}

	public function getPk() {
		return $this->pk;
	}

	public function setPk($pk) {
		$this->pk=$pk;
		return $this;
	}

	public function getInversedBy() {
		return $this->inversedBy;
	}

	public function setInversedBy($inversedBy) {
		$this->inversedBy=$inversedBy;
		return $this;
	}

	public function getInstance() {
		return $this->instance;
	}

	public function setInstance($instance) {
		$this->instance=$instance;
		return $this;
	}
	
	public function getSQL($alias="",$aliases=null){
		if($alias!==""){
			$targetEntityTable=$alias;
			$alias="`".$alias."`";
		}else{
			$targetEntityTable=$this->targetEntityTable;
		}
		$jtAlias=uniqid($this->joinTable);
		$table=$this->table;
		if(is_array($aliases)){
			if(isset($aliases[$this->table]))
				$table=$aliases[$this->table];
		}
		return " INNER JOIN `" . $this->joinTable . "` `{$jtAlias}` on `".$jtAlias."`.`".$this->myFkField."`=`".$table."`.`".$this->myPk."`".
				" INNER JOIN `" . $this->targetEntityTable . "` {$alias} on `".$jtAlias."`.`".$this->fkField."`=`".$targetEntityTable."`.`".$this->pk."`";
	}
	
	public function getConcatSQL(){
		return "SELECT `".$this->myFkField."` as '_field' ,GROUP_CONCAT(`".$this->fkField."` SEPARATOR ',') as '_concat' FROM `".$this->joinTable."` {condition} GROUP BY 1";
	}
	
	public function getParserWhereMask($mask="'{value}'"){
		return "`".$this->getTargetEntityTable()."`.`". $this->getPk() . "`=".$mask;
	}
	
	private function getParserConcatWhereMask($mask="'{value}'"){
		return "`".$this->myFkField. "`=".$mask;
	}
	
	private function getParserConcatWhereInMask($mask="'{values}'"){
		return " INNER JOIN (".$mask.") as _tmp ON `".$this->myFkField. "`=_tmp._id";
	}
	
	
	public function generateConcatSQL(){
		$sql=$this->getConcatSQL();
		$where="";
		if(($size=sizeof($this->whereValues))>0){
			if($size>3){
				$res=array_fill(0, $size, "?");
				$res[0]="SELECT ? as _id";
				$where=$this->getParserConcatWhereInMask(implode(" UNION ALL SELECT ", $res));
			}else{
				$mask=$this->getParserConcatWhereMask(" ?");
				$res=array_fill(0, $size, $mask);
				$where="WHERE ".implode(" OR ", $res);
			}
		}
		return str_replace("{condition}", $where, $sql);
	}
	
	public function addValue($value){
		$this->whereValues[$value]=true;
	}
	/**
	 * @return array
	 */
	public function getWhereValues() {
		return array_keys($this->whereValues);
	}

}
