<?php
namespace routecms\pages;

use routecms\Input;
use routecms\Routecms;
use routecms\system\event\EventManger;

/*--------------------------------------------------------------------------------------------------
Datei      		 : MultiPage.php
Beschreibung 	 : Eine Seiten Klasse für mehrfach links
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 24.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class MultiPage extends Page {

	/**
	 * Alle anzuzeigen Objekte
	 *
	 * @var    array<mixed>
	 */
	public $objects = array();
	/**
	 * Maximale Anzahl an Objekten pro Seite
	 *
	 * @var    integer
	 */
	public $maxPerPage = 20;
	/**
	 * Die Aktuelle Seite zahl
	 *
	 * @var    integer
	 */
	public $pageNo = 0;
	/**
	 * Anzahl an möglichen Seiten
	 *
	 * @var    integer
	 */
	public $pages = 0;
	/**
	 * Anzahl alle Objekte
	 *
	 * @var    integer
	 */
	public $count = 0;
	/**
	 * SQL Query um die anzahl an Daten Sätze herraus zu finden
	 *
	 * @var    string
	 */
	public $sqlCount = "";
	/**
	 * SQL Parameter für den SQL Count
	 *
	 * @var    array<mixed>
	 */
	public $sqlCountParameters = array();
	/**
	 * SQL Query
	 *
	 * @var    string
	 */
	public $sql = "";
	/**
	 * SQL Parameter für den SQL Count
	 *
	 * @var    array<mixed>
	 */
	public $sqlParameters = array();
	/**
	 * SQL sortirung
	 *
	 * @var    string
	 */
	public $sqlOrderBy = "";
	/**
	 * SQL sortirungs Feld
	 *
	 * @var    string
	 */
	public $sortField = "";
	/**
	 * SQL sortirungs Reihenfolge
	 *
	 * @var    string
	 */
	public $sortOrder = "";
	/**
	 * Datenbank Objekt Klasse
	 *
	 * @var    string
	 */
	public $class = "";

	/**
	 * @see Page::read()
	 **/
	public function read() {
		parent::read();
		$this->pageNo = Input::get("pageNo", "int", 0);
		$this->calculatePages();
		if($this->count > 0) {
			if($this->sortField && $this->sortOrder)
				$this->sqlOrderBy = $this->sortField." ".$this->sortOrder;
			$this->readObjects();
		}
	}

	/**
	 * Berechnet die anzahl der Seiten
	 **/
	public function calculatePages() {
		EventManger::event("calculatePages", get_class($this), $this);
		$this->count = $this->countItems();
		$this->pages = intval(ceil($this->count / $this->maxPerPage));
		if($this->pageNo > $this->pages)
			$this->pageNo = $this->pages;
		if($this->pageNo < 1)
			$this->pageNo = 1;
		EventManger::event("afterCalculatePages", get_class($this), $this);
	}

	/**
	 * Liest die anzahl aller Datensätze aus
	 **/
	protected function countItems() {
		EventManger::event("countItems", get_class($this), $this);
		$statement = Routecms::getDB()->statement($this->sqlCount);
		if(count($this->sqlCountParameters) > 0) {
			$statement->execute(array($this->sqlCountParameters));
		}else {
			$statement->execute();
		}
		$row = $statement->fetchArray();
		return $row["count"];
	}

	/**
	 * List alle Objekte aus der Datenbank aus
	 */
	protected function readObjects() {
		EventManger::event("beforeReadObjects", get_class($this), $this);
		$statement = Routecms::getDB()->statement($this->sql.(!empty($this->sqlOrderBy) ? " ORDER BY ".$this->sqlOrderBy : ''), $this->maxPerPage, $this->maxPerPage * ($this->pageNo - 1));
		if(count($this->sqlParameters) > 0) {
			$statement->execute(array($this->sqlParameters));
		}else {
			$statement->execute();
		}
		while($row = $statement->fetchArray()) {
			$this->objects[] = new $this->class(null, $row);
		}
		EventManger::event("readObjects", get_class($this), $this);
	}

	/**
	 * @see Page::assign()
	 **/
	public function assign() {
		parent::assign();
		Routecms::getTemplate()->assign(array('count' => $this->count,
			'pageNo' => $this->pageNo,
			'objects' => $this->objects,
			'maxPerPage' => $this->maxPerPage,
			'pages' => $this->pages));
	}
}