<?php
require_once(DIRNAME.'lib/pages/class/MultiPage.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : SortPage.php
Beschreibung 	 : Eine Seiten Klasse für mehrfach links und soritermöglichkeit
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 24.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class SortPage extends MultiPage {

	/**
	 * standard sortier Feld
	 *
	 * @var    string
	 */
	public $defaultField = '';

	/**
	 * standard sortier Reihenfolge
	 *
	 * @var    string
	 */
	public $defaultOrder = 'ASC';

	/**
	 * Eine Liste mit allen möglichen sortierebaren Felder
	 *
	 * @var    array<string>
	 */
	public $validFields = array();

	/**
	 * @see    Page::read()
	 */
	public function read() {
		$this->sortField = Input::get("sortField", "string", "");
		$this->sortOrder = Input::get("sortOrder", "string", "");

		$this->validateSort();
		parent::read();
	}

	/**
	 * Überprüft die Sortier möglichkeiten
	 */
	public function validateSort() {
		EventManger::event("beforeValidateSort", get_class($this), $this);
		switch($this->sortOrder) {
			case 'ASC':
			case 'DESC':
				break;

			default:
				$this->sortOrder = $this->defaultOrder;
		}
		EventManger::event("afterValidateOrder", get_class($this), $this);
		if(!in_array($this->sortField, $this->validFields)) {
			$this->sortField = $this->defaultField;
		}
		EventManger::event("afterValidateField", get_class($this), $this);
	}

	/**
	 * @see    Page::assign()
	 */
	public function assign() {
		parent::assign();
		Routecms::getTemplate()->assign(array('sortOrder' => $this->sortOrder,
			'sortField' => $this->sortField));
	}
}