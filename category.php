<?php
class Category {

	private $name;
	private $description;

	public function __construct($a, $b) {
		$this -> name = $a;
		$this -> description = $b;
	}

	public function getName(){
		return $this -> name; 
	}
	public function getDesc(){
		return $this -> description ;
	}
}
?>