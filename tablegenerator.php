<?php
class TableGenerator {
	public $headings;
	public $rows = [];

	public function setHeadings($headings) {
		$this->headings = $headings;
	}

	public function addRow($row) {
		$this->rows[] = $row;
	}

	public function getHTML() {
		$result = '<table style="width:900px">';

		$result = $result . '<thead class="tr_colour">';
		$result = $result . '<tr>';

		foreach ($this->headings as $heading) {
			$result = $result . '<th>' . $heading . '</th>';
		}
		$result = $result . '</thead>';
		$result = $result . '</tr>';

		$result = $result . '<tbody>';

		foreach ($this->rows as $row) {
		
			$result = $result . '<tr>';
			foreach ($row as $cell) {
				$result = $result . '<td>' . $cell . '</td>';
			}
			$result = $result . '</tr>';
		}

		$result = $result . '</tbody>';

		$result = $result . '</table>';

		return $result;
	}
}

?>