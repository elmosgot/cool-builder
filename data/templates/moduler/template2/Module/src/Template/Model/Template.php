<?php
namespace %1$s\Model;

class %1$s {
	public $id;
	public $name;
	public $lastUpdated;
	public $date;

	public function exchangeArray( $data ) {
		$this->id = (isset($data['id'])) ? (int) $data['id'] : null;
		$this->name = (isset($data['name'])) ? $data['name'] : null;
		$this->lastUpdated = (isset($data['last_updated'])) ? $data['last_updated'] : null;
		$this->date = (isset($data['date'])) ? $data['date'] : null;
	}
}
