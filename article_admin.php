<?php
class Article_Admin {

	private $title;
	private $category;
	private $a_date;
	private $content;
	private $link;

	public function __construct($a, $b, $c, $d, $e) {
		$this -> title = $a;
		$this -> category = $b;
		$this -> a_date = $c;
		$this -> content = $d;
		$this -> link = $e;
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
	
	public function getLink(){
		return $this -> link ;
	}
}
?>