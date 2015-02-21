<?php
namespace routecms\system\user\group;

use routecms\exception\SystemException;
use routecms\Routecms;
use routecms\system\DBObject;

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOption.php
Beschreibung 	 : System Klasse des Routecmss
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 08.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOption extends dbObject {

	/**
	 * @see    dbObject::$dbName
	 */
	protected static $dbName = 'group_option';
	/**
	 * @see    dbObject::$dbIndex
	 */
	protected static $dbIndex = 'optionID';
	/**
	 * Eine Liste mit dem Inhalt der Option und den passenden Gruppen
	 *
	 * @var array<mixed>
	 */
	public $values = array();

	/**
	 * Gibt den Options Handler zurück
	 *
	 * @param Group   $group
	 * @param boolean $post
	 *
	 * @return string
	 * @throws SystemException
	 */
	public function getOutput(Group $group, $post = false) {
		$className = 'routecms\system\user\group\optionType\output\GroupOptionOutputType'.ucfirst($this->type);
		return new $className($this, $group, $post);
	}

	/**
	 * Ruft den Inhalt der aktuellen Option für eine bestimmte Gruppe ab
	 *
	 * @param integer $groupID
	 *
	 * @return mixed
	 */
	public function getValue($groupID) {
		if(!isset($this->values[$groupID])) {
			$sql = "SELECT	value
			FROM	".DB_PREFIX."group_option_value
			WHERE	optionID = ? AND groupID = ?";
			$statement = Routecms::getDB()->statement($sql, 1);
			$statement->execute(array($this->optionID,
				$groupID));
			$row = $statement->fetchArray();
			if($row && isset($row["value"])) {
				$this->values[$groupID] = $row["value"];
			}
		}
		if(isset($this->values[$groupID])) {
			return $this->values[$groupID];
		}else {
			return null;
		}
	}

	/**
	 * Gibt eine Berechtigung des aktuellen Benutzers zurück mit gegebener Options Namen
	 *
	 * @param string $permission
	 *
	 * @return mixed
	 * @throws SystemException
	 */
	public static function getOptionValue($permission) {
		$sql = "SELECT	optionID
			FROM	".DB_PREFIX."group_option
			WHERE	name = ?";
		$statement = Routecms::getDB()->statement($sql, 1);
		$statement->execute(array($permission));
		$row = $statement->fetchArray();
		if(!$row) {
			throw new SystemException(Routecms::getLanguage()->get("exception.system.error.false.permission"));
		}
		if(!isset($row["optionID"])) {
			throw new SystemException(Routecms::getLanguage()->get("exception.system.error.false.permission"));
		}
		return self::getOptionValueByID(intval($row["optionID"]));
	}

	/**
	 * Gibt eine Berechtigung des aktuellen Benutzers zurück mit gegebener Options ID
	 *
	 * @param integer $optionID
	 *
	 * @return mixed
	 * @throws SystemException
	 */
	public static function getOptionValueByID($optionID) {
		$option = new GroupOption(intval($optionID));
		if(!$option && $option->optionID == null && $option->optionID == 0) {
			throw new SystemException(Routecms::getLanguage()->get("exception.system.error.false.optionID"));
		}

		$className = 'routecms\system\user\group\optionType\GroupOptionType'.ucfirst($option->type);
		$optionType = new $className($option, Routecms::getUser()->getGroupIDs());
		return $optionType->getValue();
	}
}