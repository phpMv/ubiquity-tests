<?php

namespace Ubiquity\contents\validation\validators\comparison;

use Ubiquity\contents\validation\validators\ValidatorHasNotNull;

class LessThanOrEqualValidator extends ValidatorHasNotNull {
	
	protected $ref;
	public function __construct(){
		$this->message="This value should be less or equal than `{ref}`";
	}
	public function validate($value) {
		parent::validate($value);
		return $value<=$this->ref;
	}
	/**
	 * {@inheritDoc}
	 * @see \Ubiquity\contents\validation\validators\Validator::getParameters()
	 */
	public function getParameters(): array {
		return ["ref","value"];
	}

}

