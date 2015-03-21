<?php
namespace routecms\system;

use routecms\Routecms;
use routecms\system\event\EventManger;

/*--------------------------------------------------------------------------------------------------
Datei      		 : DBObject.php
Beschreibung 	 : Datenbank Objekt Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 27.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class DBObject {

	/**
	 * Datenbank Index spalten Name
	 *
	 * @var    string
	 */
	protected static $dbIndex = '';
	/**
	 * Datenbank name
	 *
	 * @var    string
	 */
	protected static $dbName = '';
	/**
	 * Datenbank Objekt Variablen
	 *
	 * @var    array
	 */
	protected $values = array();

	/**
	 * Inizalisiert das Datenbank Objekt
	 *
	 * @param integer $ID
	 * @param array   $row
	 */
	public function __construct($ID, array $row = null) {
		EventManger::event("beforeConstruct", get_class($this), $this);
		if($ID !== null) {
			$sql = "SELECT	*
				FROM	".static::getDBName()."
				WHERE	".static::$dbIndex." = ?";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($ID));
			$row = $statement->fetchArray();
			if($row === false)
				$row = array();
		}
		$this->values = $row;
		EventManger::event("afterConstruct", get_class($this), $this);
	}

	/**
	 * Gibt den Namen mit Prefix der Datenbank zurück
	 */
	public static function getDBName() {
		return DB_PREFIX.static::$dbName;
	}

	/**
	 * Gibt den Namen des Index der Datenbanktabelle zurück
	 */
	public static function getDBIndexName() {
		return static::$dbIndex;
	}

	/**
	 * Gibt das aktuelle object durch eine andere Spalten Index zurück
	 *
	 * @param string $name
	 * @param string $value
	 * @param string $namespace
	 *
	 * @return object
	 */
	public static function getBy($name, $value, $namespace) {
		$sql = "SELECT	*
				FROM	".static::getDBName()."
				WHERE	".$name." = ?";
		$statement = Routecms::getDB()->statement($sql, 1);
		$statement->execute(array($value));
		return $statement->fetchObject($namespace);
	}

	/**
	 * Fügt ein SQL Object hinzu
	 *
	 * @param array $array
	 */
	public static function create($array) {
		$sql = "INSERT INTO	".static::getDBName()." (";
		$sqlValues = ' VALUES(';
		foreach($array as $key => $value) {
			$sql .= $key.", ";
			$sqlValues .= "?, ";
			$values[] = $value;
		}
		$sqlValues = substr($sqlValues, 0, -2);
		$sqlValues .= ")";
		$sql = substr($sql, 0, -2);
		$sql .= ")";
		$sql = $sql.$sqlValues;
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute($values);
	}

	/**
	 * Gibt das Letzte Element zurück
	 *
	 * @return array
	 */
	public static function getLast() {
		$sql = "SELECT * FROM	".static::getDBName()." ORDER BY ".static::$dbIndex." DESC";
		$statement = Routecms::getDB()->statement($sql, 1);
		$statement->execute();
		return $statement->fetchArray();
	}

	/**
	 * Gibt eine Variabel des Datenbank Objektes zurück
	 *
	 * @param string $name
	 *
	 * @return object
	 */
	public function __get($name) {
		if(isset($this->values[$name])) {
			return $this->values[$name];
		}else {
			return null;
		}
	}

	/**
	 * Überpürft ob eine Variable existiert
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function __isset($name) {
		return isset($this->values[$name]);
	}


	/**
	 * Verändert eine Variabel
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function __set($name, $value) {
		if(isset($this->values[$name])) {
			$this->values[$name] = $value;
		}
	}

	/**
	 * Bearbeitet einen SQL Datenbank eintrag
	 *
	 * @param array $update
	 */
	public function update($update) {
		EventManger::event("beforeUpdate", get_class($this), $this);
		if(count($update) > 0) {
			$values = array();
			$sql = "UPDATE	".static::getDBName()." SET ";
			foreach($update as $key => $value) {
				$sql .= $key." = ? ,";
				$values[] = $value;
			}
			$sql = substr($sql, 0, -2);
			$sql .= " WHERE ".static::$dbIndex." = ?";
			$values[] = static::getDBIndex();
			$statement = Routecms::getDB()->statement($sql, 1);
			$statement->execute($values);
			EventManger::event("afterUpdate", get_class($this), $this);
		}
	}

	/**
	 * Gibt den Datenbank Index zurück
	 *
	 * @return mixed
	 */
	public function getDBIndex() {
		return $this->values[static::$dbIndex];
	}

}