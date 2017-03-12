<?php

class Category_Admin {

private $name;
private $description;
private $link;

public function __construct($a, $b, $c) {
$this -> name = $a;
$this -> description = $b;
$this -> link = $c;
}

public function getName(){
return $this -> name; 
}

public function getDesc(){
return $this -> description ;
}

public function getLink(){
return $this -> link ;
}

}

?>