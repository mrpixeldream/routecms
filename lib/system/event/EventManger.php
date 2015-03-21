<?php
namespace routecms\system\event;

use routecms\Routecms;

/*--------------------------------------------------------------------------------------------------
Datei      		 : EventManger.php
Beschreibung 	 : Die Verwaltungs Klasse für die Events der Klassen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class EventManger {

	/**
	 * Alle gespeicherten Events die ausgeführt werden können
	 *
	 * @var    array
	 */
	protected static $events = array();

	/**
	 * Alle gespeicherten EventIDs zu den Passenden Events
	 *
	 * @var    array
	 */
	protected static $action = array();

	/**
	 * Lädt alle Events aus der Datenbank
	 */
	public static function loadEvents() {
		$sql = "SELECT	* FROM ".DB_PREFIX."event";
		if(defined('ADMIN')) {
			$sql .= " WHERE admin = 1";
		}else {
			$sql .= " WHERE admin = 0";
		}
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute();
		while($row = $statement->fetchArray()) {
			$object = new EventObject(null, $row);
			self::$events[$object->eventID] = $object;
			self::$action[self::getEventKey($object->event, $object->eventClass)][] = $object->eventID;
		}
	}

	/**
	 * Gibt für das Event einen Key zurück
	 *
	 * @param string $event
	 * @param string $class
	 *
	 * @return string
	 */
	protected static function getEventKey($event, $class) {
		return $event.'@'.$class;
	}

	/**
	 * Führt ein Event oder mehrere aus
	 *
	 * @param string $event
	 * @param string $class
	 * @param mixed  $object
	 */
	public static function event($event, $class, $object) {
		$key = self::getEventKey($event, $class);
		if(isset(self::$action[$key]) && is_array(self::$action[$key])) {
			$list = self::$action[$key];
			foreach($list as $id) {
				if(isset(self::$events[$id])) {
					$eventObject = self::$events[$id];
					$class = $eventObject->getClass();
					if(class_exists($class)) {
						new $class($event, $class, $object);
					}

				}
			}
		}
	}
}