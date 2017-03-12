<?php

class User {

private $name;
private $surname;
private $email;
private $link;

public function __construct($a, $b, $c, $d) {
$this -> name = $a;
$this -> surname = $b; 
$this -> email = $c;
$this -> link = $d; 
}

public function getName(){
return $this -> name; 
}
public function getSurname(){
return $this -> surname;
}

public function getEmail(){
return $this -> email; 
}

public function getLink(){
return $this -> link; 
}

}

?>