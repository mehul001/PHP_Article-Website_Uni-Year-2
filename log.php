<?php

class Log {

private $date;
private $type;
private $desc;
private $id;
private $name;

public function __construct($a, $b, $c, $d, $e) {		
$this -> date = $a;
$this -> type = $b;
$this -> desc = $c;
$this -> id = $d;
$this -> name = $e;
}

public function getDate (){
return $this -> date;
}

public function getType(){
return $this -> type; 
}

public function getDesc(){
return $this -> desc; 
}

public function getId(){
return $this -> id; 
}

public function getName(){
return $this -> name;
}

}

?>