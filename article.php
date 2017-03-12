<?php
class Article {

	private $title;
	private $category;
	private $a_date;
	private $content;

	public function __construct($a, $b, $c, $d) {
		$this -> title = $a;
		$this -> category = $b;
		$this -> a_date = $c;
		$this -> content = $d;
	}

	public function getTitle(){
		return $this -> title; 
	}
	public function getCategory(){
		return $this -> category;
	}
	
	public function getDate(){
		return $this -> a_date; 
	}
	public function getContent(){
		return $this -> content;
	}
}
?>