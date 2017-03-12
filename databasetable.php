<?php
class DatabaseTable {
	private $table;
	private $pdo;

public function __construct($pdo, $table) {
	$this->pdo = $pdo;
	$this->table = $table;
}

public function select() {
	$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
		
	$stmt->execute();
	return $stmt->fetchAll();
}

public function find($field, $value) {
	$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . '= :value');
		$criteria = [
		'value' => $value
		];
	$stmt->execute($criteria);
	return $stmt->fetchAll();
}

public function findLogin($field, $value) {
	$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . '= :value');
		$criteria = [
		'value' => $value
		];
	$stmt->execute($criteria);
	return $stmt->fetch();
}

public function delete($field, $value) {
	$stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $field . '= :value');
		$criteria = [
		'value' => $value
		];
	$stmt->execute($criteria);
	return $stmt->fetchAll();
}

public function where_like($field, $value, $field2, $value2) {
	$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . '= :value AND ' . $field2 . ' LIKE "%" :value2 "%"');
		$criteria = [
		'value' => $value,
		'value2' => $value2
		];
	$stmt->execute($criteria);
	return $stmt->fetchAll();
}

public function update($pdo, $record, $table, $pk, $pk_v){   
	$query = 'UPDATE ' . $table . ' SET ';   
	$parameters = [];   
	foreach($record as $key => $value){
		$parameters[] = $key . ' = :' .$key;
	}   
	$query .= implode(', ', $parameters);
	$query .= ' WHERE ' . $pk . ' = :primaryKey';
	$record['primaryKey'] = $pk_v;   
	$stmt = $pdo->prepare($query);
	$stmt->execute($record);   
}
  
function insert($pdo, $table, $record) {
	$keys = array_keys($record);
	$values = implode(', ', $keys);
	$valuesWithColon = implode(', :', $keys);
	$query = 'INSERT INTO ' . $table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
	$stmt = $pdo->prepare($query);
	$stmt->execute($record);
} 

}
?>