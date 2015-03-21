<?php
namespace routecms\system\event;

use routecms\system\DBObject;

/*--------------------------------------------------------------------------------------------------
Datei      		 : EventObject.php
Beschreibung 	 : Datenbank Klasse für die Events
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 20.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class EventObject extends DBObject {
	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'event';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'eventID';

	/**
	 * Gibt den Klassen Namen zurück
	 *
	 * @return string
	 */
	public function getClass() {
		return 'routecms\system\event\events\\'.$this->class.'Event';
	}
}