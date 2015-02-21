<?php
namespace routecms\system\menu;

use routecms\Routecms;
use routecms\system\DBObject;
use routecms\system\event\EventManger;
use routecms\system\user\session\Session;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Menu.php
Beschreibung 	 : CMS Menü Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Menu extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'menu';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'menuID';
	/**
	 * Die unter Menü Punkte
	 *
	 * @var    array<menu>
	 */
	public $parentItems = array();

	/**
	 * Gibt das Menü für das ACP zurück
	 *
	 * @param Session $session
	 *
	 * @return array<menu>
	 */
	public static function generateMenu(Session $session) {
		$result = array();
		$sql = "SELECT	*
			FROM	 ".DB_PREFIX."menu
			WHERE	parent = '' ORDER BY position ASC";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute();
		while($row = $statement->fetchArray()) {
			$menu = new Menu(null, $row);
			if(in_array($session->groupID, explode(",", $menu->groupIDs))) {
				$result[] = $menu;
			}
		}
		return $result;
	}

	/**
	 * Gibt die unter Menü Punkte für das ACP zurück
	 *
	 * @return array<menu>
	 */
	public function getParent() {
		EventManger::event("beforeReadParentMenu", get_class($this), $this);
		if($this->parentItems == null) {
			$sql = "SELECT	*
			FROM	 ".DB_PREFIX."menu
			WHERE	parent = ? ORDER BY position ASC";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->name));
			$session = Routecms::getSession();
			while($row = $statement->fetchArray()) {
				$menu = new Menu(null, $row);
				if(in_array($session->groupID, explode(",", $menu->groupIDs))) {
					$this->parentItems[] = $menu;
				}
			}
		}
		EventManger::event("beforeReturnParentMenu", get_class($this), $this);
		return $this->parentItems;
	}
}