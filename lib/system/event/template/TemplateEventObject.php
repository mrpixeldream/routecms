<?php
require_once(DIRNAME.'lib/system/dbObject.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : TemplateEventObject.php
Beschreibung 	 : Datenbank Klasse für die Template Events
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 19.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class TemplateEventObject extends DBObject {
	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'template_event';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'templateEventID';

	/**
	 * Gibt den Pfad zu der Template Datei dieses Events zurück
	 *
	 * @return string
	 */
	public function getPath() {
		if($this->admin){
			return DIRNAME.'lib/admin/template/'.$this->templateInclude.'.tpl';
		}else{
			return DIRNAME.'lib/template/'.$this->templateInclude.'.tpl';
		}
	}
}