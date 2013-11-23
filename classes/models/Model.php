<?php

namespace models;

use ReflectionClass;

class Model {

	/**
	 * @column id
	 * @var integer
	 */
	public $id;

	/**
	 *
	 * @var boolean
	 */
	protected $isValid = null;

	/**
	 *
	 * @var array
	 */
	protected $validationMessages = null;

	/**
	 * perform model validation against rules
	 *
	 * @return void
	 */
	public function validate() {
		$this->validationMessages = array();
	}

	/**
	 * get validation messages
	 *
	 * @param string $attribute if not null, get messages for a specific attribute
	 * @return array
	 */
	public function getValidationMessages($attribute = null) {
		if ($this->validationMessages === null) {
			$this->validate();
		}

		if ($attribute === null) {
			return $this->validationMessages;
		} else if ($attribute !== null && array_key_exists($attribute, $this->validationMessages)) {
			return $this->validationMessages[$attribute];
		}
		return array(); // no messages
	}

	/**
	 * return if model validates with attribute values
	 *
	 * @uses Model::validate() if wasn't called before
	 * @return boolean
	 */
	public function isValid() {
		if ($this->isValid !== null) {
			return $this->isValid;
		} else if (empty($this->validationMessages)) {
			$this->validate();
		}
		$this->isValid = empty($this->validationMessages);
		return $this->isValid;
	}

	/**
	 * set all public attributes from array
	 *
	 * @param array $attributes
	 * @return void
	 */
	public function setAttributes(array $attributes) {
		$reflected_class = new ReflectionClass($this);
		foreach ($attributes as $name => $value) {
			if ($reflected_class->hasProperty($name)) {
				$reflected_method = new \ReflectionProperty($this, $name);
				if ($reflected_method->isPublic()) {
					$this->{$name} = $value;
				}
			}
		}
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 *
	 * @param array $attributes default properties
	 */
	public function __construct($attributes = array()) {
		if (!empty($attributes)) {
			$this->setAttributes($attributes);
		}
	}
}
