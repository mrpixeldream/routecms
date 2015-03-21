<?php
namespace routecms\system\db;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Database.php
Beschreibung 	 : Datenbank Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Database {

	/**
	 *  Datenbank Host name
	 *
	 * @var    string
	 */
	protected $host;
	/**
	 * Datenbank Name
	 *
	 * @var    string
	 */
	protected $db;
	/**
	 * Datenbank Username
	 *
	 * @var    string
	 */
	protected $user;
	/**
	 * Datenbank Password
	 *
	 * @var    string
	 */
	protected $pw;
	/**
	 * Aktuelles PDO Objekt
	 *
	 * @var    /PDO Objekt
	 */
	protected $pdo = null;

	/**
	 * Inizalisiert die Datenbank
	 *
	 * @param string $host
	 * @param string $db
	 * @param string $user
	 * @param string $pw
	 */
	public function __construct($host, $db, $user, $pw) {
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pw = $pw;
		$this->connect();
	}

	/**
	 * Verbindet sich mit dem MYSQL Server
	 */

	protected function connect() {
		$option = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8', SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY,STRICT_ALL_TABLES'");
		$this->pdo = new \PDO('mysql:host='.$this->host.';port=3306;dbname='.$this->db, $this->user, $this->pw, $option);
		$this->setAttributes();
	}

	/**
	 * Fügt dem PDO Attribut hinzu
	 */
	protected function setAttributes() {
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
		$this->pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
	}

	/**
	 * Die escapeString methode für die SQL Abfragen
	 */
	public function escapeString($string) {
		return addslashes($string);
	}

	/**
	 * Gibt ein Prepare Statment objekt zurück
	 *
	 * @param string  $statement
	 * @param integer $limit
	 * @param integer $offset
	 *
	 * @return Statement Objekt
	 */
	public function statement($statement, $limit = 0, $offset = 0) {
		$query = $this->limitHandler($statement, $limit, $offset);
		return new Statement($this, $this->pdo->prepare($query), $query);
	}

	/**
	 * Fügt in die SQL Abfrage das Limitieren von Datensetzen ein
	 *
	 * @param string  $query
	 * @param integer $limit
	 * @param integer $offset
	 *
	 * @return string
	 */
	public function limitHandler($query, $limit = 0, $offset = 0) {
		if($limit != 0) {
			if($offset > 0)
				$query .= " LIMIT ".$offset.", ".$limit;else $query .= " LIMIT ".$limit;
		}

		return $query;
	}
}


