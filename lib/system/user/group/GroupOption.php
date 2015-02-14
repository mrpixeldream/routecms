<?php
require_once(DIRNAME.'lib/system/dbObject.php');
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
	 * Gibt den Options Handler zurück
	 *
	 * @param Group $group
	 *
	 * @return string
	 * @throws SystemException
	 */
	public function getOutput($group){
		$className = 'GroupOptionOutputType'.ucfirst($this->type);
		$path = DIRNAME.'lib/system/user/group/optionType/output/'.$className.'.php';
		if(!file_exists($path)){
			throw new SystemException(lang("exception.system.error.option.output.type.file"));
		}
		require_once($path);
		if(!class_exists($className)){
			throw new SystemException(lang("exception.system.error.option.output.type.no.class"));
		}
		return new $className($this,$group);
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
			throw new SystemException(lang("exception.system.error.false.permission"));
		}
		if(!isset($row["optionID"])){
			throw new SystemException(lang("exception.system.error.false.permission"));
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
	public static function getOptionValueByID($optionID){
		$option = new GroupOption(intval($optionID));
		if(!$option && $option->optionID ==  null && $option->optionID == 0){
			throw new SystemException(lang("exception.system.error.false.optionID"));
		}
		$className = 'GroupOptionType'.ucfirst($option->type);
		$path = DIRNAME.'lib/system/user/group/optionType/'.$className.'.php';
		if(!file_exists($path)){
			throw new SystemException(lang("exception.system.error.option.type.file"));
		}
		require_once($path);
		if(!class_exists($className)){
			throw new SystemException(lang("exception.system.error.option.type.no.class"));
		}
		$optionType = new $className($option, Routecms::getUser()->getGroupIDs());
		return $optionType->getValue();
	}
}