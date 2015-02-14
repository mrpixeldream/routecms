<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : Statement.php
Beschreibung 	 : Prepared statement Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Statement {

	/**
	 * SQL Parameter array
	 *
	 * @var    array
	 */
	protected $parameters = array();
	/**
	 * Aktuelles Datenbank objekt
	 *
	 * @var    User Objekt
	 */
	protected $db = null;
	/**
	 * Aktuelles Prepared statement objekt
	 *
	 * @var    /PDO Objekt
	 */
	protected $pdo = null;
	/**
	 * Aktuelles SQL Abfrage
	 *
	 * @var    User Objekt
	 */
	protected $query = '';

	/**
	 * Inizalisiert die Prepared Statment Class
	 *
	 * @param Database $db
	 * @param /PDOStatement $pdo
	 * @param string   $query
	 */
	public function __construct(Database $db, \PDOStatement $pdo, $query = '') {
		$this->database = $db;
		$this->pdo = $pdo;
		$this->query = $query;
	}

	/**
	 * Ruft eine Funtkion der PDOStatement class auf
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return object
	 */
	public function __call($name, $arguments) {
		return call_user_func_array(array($this->pdo,
			$name), $arguments);
	}

	/**
	 * Führt eine SQL Abfrage mit gegeben Parametern aus
	 *
	 * @param array $parameters
	 */
	public function execute(array $parameters = array()) {
		$this->parameters = $parameters;
		if(empty($parameters))
			$this->pdo->execute();else $this->pdo->execute($parameters);
	}

	/**
	 * Gibt die aktuelle Spalte der SQL Abfrage Class Objekt zurück
	 *
	 * @param string $path
	 * @param string $className
	 *
	 * @return object
	 */
	public function fetchObject($path, $className) {
		require_once($path);
		$row = $this->fetchArray();
		if($row !== false) {
			return new $className(null, $row);
		}

		return null;
	}

	/**
	 * Holt aus der SQL Abfrage die nächste Spalte raus und gibt diese zurück
	 *
	 * @param integer $type
	 *
	 * @return array
	 */
	public function fetchArray($type = null) {
		if($type === null)
			$type = \PDO::FETCH_ASSOC;
		return $this->fetch($type);
	}
}