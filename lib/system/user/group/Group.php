<?php
require_once(DIRNAME.'lib/system/dbObject.php');
/*--------------------------------------------------------------------------------------------------
Datei      		 : Group.php
Beschreibung 	 : Gruppen Klassen des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 27.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Group extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'group';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'groupID';
}