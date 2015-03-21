<?php
namespace routecms\system\menu;

use routecms\Routecms;
use routecms\system\DBObject;
use routecms\system\event\EventManger;
use routecms\system\user\session\Session;

/*--------------------------------------------------------------------------------------------------
Datei      		 : AdminMenu.php
Beschreibung 	 : Admin Menü Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 15.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class AdminMenu extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'admin_menu';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'menuID';
	/**
	 * Die unter Menü Punkte
	 *
	 * @var    array<menu>
	 */
	public $parentItems = null;

	/**
	 * Gibt das Menü für das ACP zurück
	 *
	 * @param Session $session
	 *
	 * @return array<AdminMenu>
	 */
	public static function generateMenu(Session $session) {
		$result = array();
		$sql = "SELECT	*
			FROM	 ".DB_PREFIX."admin_menu
			WHERE	parent = '' ORDER BY position ASC";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute();
		while($row = $statement->fetchArray()) {
			$menu = new AdminMenu(null, $row);
			if(!empty($menu->permissions)) {
				if(Routecms::checkPermission($menu->permissions)) {
					$result[] = $menu;
				}
			}else {
				$result[] = $menu;

			}
		}
		return $result;
	}

	/**
	 * Gibt die unter Menü Punkte für das ACP zurück
	 *
	 * @return array<AdminMenu>
	 */
	public function getParent() {
		EventManger::event("beforeReadParentMenu", get_class($this), $this);
		if($this->parentItems == null) {
			$this->parentItems = array();
			$sql = "SELECT	*
			FROM	 ".DB_PREFIX."admin_menu
			WHERE	parent = ? ORDER BY position ASC";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->name));
			$session = Routecms::getSession();
			while($row = $statement->fetchArray()) {
				$menu = new AdminMenu(null, $row);
				$this->parentItems[] = $menu;
			}
		}
		EventManger::event("beforeReturnParentMenu", get_class($this), $this);
		return $this->parentItems;
	}
}