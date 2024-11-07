<?php

class Metadata implements JsonSerializable {
    private $id;
    private $msg;

    public function __construct($id, $msg){
        $this->id = $id;
        $this->msg = $msg;
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
		$objectArray = [];
		foreach ($this as $key => $value) {
			$objectArray[$key] = $value;
		}
		return json_encode($this, JSON_UNESCAPED_UNICODE);
	}
}
