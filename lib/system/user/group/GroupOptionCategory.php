<?php
require_once(DIRNAME.'lib/system/dbObject.php');
require_once(DIRNAME.'lib/system/user/group/GroupOption.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOptionCategory.php
Beschreibung 	 : System Klasse des Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 27.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOptionCategory extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'group_option_category';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'categoryID';
	/**
	 * Liste mit Übergeordneten Kateogiren
	 *
	 * @var array<GroupOptionCategory>
	 */
	protected $parent = null;
	/**
	 * Liste mit Übergeordneten Kateogiren
	 *
	 * @var array<GroupOption>
	 */
	protected $options = null;

	/**
	 * Gibt eine Liste mit den Options Katogieren uzurück
	 *
	 * @return array<GroupOptionCategory>
	 */
	public static function getTree() {
		$tree = array();
		$sql = "SELECT	*
			FROM	".DB_PREFIX."group_option_category
			WHERE	parent IS NULL ORDER BY position ASC";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute();
		while($row = $statement->fetchArray()) {
			$category = new GroupOptionCategory(null, $row);
			$tree[$category->categoryID] = $category;
		}
		return $tree;
	}

	/**
	 * Gibt eine Liste mit den Options Katogieren zurück
	 *
	 * @return array<GroupOptionCategory>
	 */
	public function getParent() {
		if(is_null($this->parent)) {
			$this->parent = array();
			$sql = "SELECT	*
			FROM	".DB_PREFIX."group_option_category
			WHERE	parent = ? ORDER BY position ASC";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->name));
			while($row = $statement->fetchArray()) {
				$category = new GroupOptionCategory(null, $row);
				$this->parent[$category->categoryID] = $category;
			}
		}
		return $this->parent;
	}
	/**
	 * Gibt eine Liste mit den Optionen dieser Kategorie zurück
	 *
	 * @return array<GroupOption>
	 */
	public function getOptionList(){
		if(is_null($this->options)) {
			$this->options = array();
			$sql = "SELECT	*
			FROM	".DB_PREFIX."group_option
			WHERE	category = ? ORDER BY position ASC";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->name));
			while($row = $statement->fetchArray()) {
				$option = new GroupOption(null, $row);
				$this->options[$option->optionID] = $option;
			}
		}
		return $this->options;
	}

}