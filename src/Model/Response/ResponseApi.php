<?php

class ResponseApi implements JsonSerializable {
	private $success;
	private $metadata;
	private $data;


	public function initialize($succes, Metadata $metadata, $data = null) {

		$this->success = $succes;
		$this->metadata = $metadata;
		$this->data = $data;
	}


	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}


	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			if (is_string($value)) {
				$this->$property = utf8_encode($value);
			} else {
				$this->$property = $value;
			}
		}
	}


	public function jsonSerialize() {
		return get_object_vars($this);
	}


	public function _toJson() {
		return json_encode($this, JSON_UNESCAPED_UNICODE);
	}
}
