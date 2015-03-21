<?php
namespace routecms\system\user\group;

use routecms\system\DBObject;

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