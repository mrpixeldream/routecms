<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : Table.php
Beschreibung 	 : Eine Hilfsklasse um Tabellen zu erstellen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Table {

	/**
	 * Eine Liste mit allen Namen des Tabellen Kopfes
	 *
	 * @var    array<array>
	 */
	public $name = array();
	/**
	 * Eine Liste mit allen Variabeln der Tabelle
	 *
	 * @var    array<mixed>
	 */
	public $values = array();
	/**
	 * Der Name/-n der Tabellen Klasse
	 *
	 * @var    string
	 */
	public $class = '';
	/**
	 * Die Breite der Tabelle
	 *
	 * @var    string
	 */
	public $width = '';

	/**
	 * Erstellt eine Hilfsklasse um eine Tabelle zu erstellen
	 *
	 * @param array  $name
	 * @param string $class
	 * @param string $width
	 */
	public function __construct(array $name, $class = 'responsive', $width = '100%') {
		EventManger::event("beforeConstruct", get_class($this), $this);
		$this->name = $name;
		$this->class = $class;
		$this->width = $width;
		EventManger::event("afterConstruct", get_class($this), $this);
	}

	/**
	 * Fügt eine Variable in der Liste hinzu
	 *
	 * @param mixed $value
	 */
	public function addValue($value) {
		EventManger::event("addValue", get_class($this), $this);
		$this->values = array_merge($this->values, array($value));
	}

	/**
	 * Fügt Variablen in der Liste hinzu
	 *
	 * @param array $values
	 */
	public function addValues(array $values) {
		EventManger::event("addValues", get_class($this), $this);
		$this->values = array_merge($this->values, $values);
	}

	/**
	 * Gibt die Tabelle aus
	 */

	public function output() {
		EventManger::event("beforeOutputStart", get_class($this), $this);
		$string = '<table';
		if(!empty($this->class)) {
			$string .= ' class="'.$this->class.'"';
		}
		if(!empty($this->width)) {
			$string .= ' style="width:'.$this->width.'"';
		}
		$string .= '>';
		$string .= '<thead>
		<tr>';
		foreach($this->name as $name) {
			$string .= '<th';
			if(isset($name["options"])) {
				foreach($name["options"] as $option) {
					$string .= ' '.$option;
				}
			}
			$string .= '>';
			$string .= lang($name["name"]);
			$string .= '</th>';
		}
		$string .= '</tr>
		</thead>
		<tbody>';
		$count = 0;
		$max = count($this->values);
		for($i = 0; $i < $max; $i++) {
			if($count == 0) {
				$string .= '<tr>';
				$count++;
			}
			if($count > count($this->name)) {
				$string .= '</tr>';
				$string .= '<tr>';
				$count = 1;
			}
			$string .= '<td>';
			$string .= $this->values[$i];
			$string .= '</td>';
			$count++;

		}

		$string .= '</tbody>
			</table>';
		EventManger::event("beforeOutput", get_class($this), $this);
		echo $string;
		EventManger::event("afterOutput", get_class($this), $this);
	}
}