<?php
require_once(DIRNAME.'lib/system/dbObject.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : EventObject.php
Beschreibung 	 : Datenbank Klasse für die Events
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
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
	 * Gibt den Pfad zu der Klasse dieses Events zurück
	 *
	 * @return string
	 */
	public function getPath() {
		return DIRNAME.'lib/system/event/events/'.$this->class.'Event.php';
	}
}