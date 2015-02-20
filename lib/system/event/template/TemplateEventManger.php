<?php
namespace routecms\system\event\template;
use routecms\Routecms;

/*--------------------------------------------------------------------------------------------------
Datei      		 : TemplateEventManger.php
Beschreibung 	 : Die Verwaltungs Klasse für die Template Events
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 11.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class TemplateEventManger {

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
		$sql = "SELECT	* FROM ".DB_PREFIX."template_event";
		if(defined('ADMIN')) {
			$sql .= " WHERE admin = 1";
		}else {
			$sql .= " WHERE admin = 0";
		}
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute();
		while($row = $statement->fetchArray()) {
			$object = new TemplateEventObject(null, $row);
			self::$events[$object->temaplteEventID] = $object;
			self::$action[self::getEventKey($object->templateEvent, $object->templateName)][] = $object->temaplteEventID;
		}
	}

	/**
	 * Gibt für das Template Event einen Key zurück
	 *
	 * @param string $event
	 * @param string $template
	 *
	 * @return string
	 */
	protected static function getEventKey($event, $template) {
		return $event.'@'.$template;
	}

	/**
	 * Gibt eine Liste mit Template Events zurück
	 *
	 * @param string $event
	 * @param string $template
	 *
	 * @return array<TemplateEventObject>
	 */
	public static function event($event, $template) {
		$result = array();
		$key = self::getEventKey($event, $template);
		if(isset(self::$action[$key]) && is_array(self::$action[$key])) {
			$list = self::$action[$key];
			foreach($list as $id) {
				if(isset(self::$events[$id])) {
					$eventObject = self::$events[$id];
					if(file_exists($eventObject->getPath())) {
						$result[] = $eventObject;
					}
				}
			}
		}
		return $result;
	}
}