<?php
namespace routecms\system\option;

use routecms\Routecms;
use routecms\system\DBObject;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Option.php
Beschreibung 	 : Options Klasse des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Option extends dbObject {
	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'options';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'optionID';

	/**
	 * Gibt den Inhalt einer Option zurück
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public static function getOptionValue($name) {
		$sql = "SELECT	*
				FROM	".self::getDBName()."
				WHERE	optionName = ?";
		$statement = Routecms::getDB()->statement($sql, 1);
		$statement->execute(array($name));
		$row = $statement->fetchArray();
		$value = $row["value"];
		return $value;
	}
}