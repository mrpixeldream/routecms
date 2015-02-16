<?php
require_once(DIRNAME . 'lib/system/user/group/optionType/output/AbstractGroupOptionOutputType.php');
require_once(DIRNAME . 'lib/system/user/group/Group.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOptionOutputTypeGroupList.php
Beschreibung 	 : Gruppen Options Ausgabe Klasse für Boolean Optionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 08.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOptionOutputTypeGroupList extends AbstractGroupOptionOutputType{

	/**
	 * @see AbstractGroupOptionOutputType::getTemplate()
	 */
	public function getTemplate(){
		$groupList = array();
		$sql = "SELECT * FROM " . DB_PREFIX . "group";
		$statement = Routecms::getDB()->statement($sql);
		$statement->execute();
		while($row = $statement->fetchArray()){
			$groupList[$row["groupID"]] = new Group(null, $row);
		}
		Routecms::getTemplate()->assign(array('groupList' => $groupList));
		return "groupOptionGroupList";
	}

	/**
	 * Ruft den Wert der Option ab
	 */
	protected function loadValue(){
		$values = Input::post("groupOptionValues", "array", array());
		if(isset($values[$this->option->name]) && is_array($values[$this->option->name])){
			$values = ArrayUtil::toIntegerArray($values[$this->option->name]);
			$this->value = implode("\n", $values);
		}else{
			$this->value = "";
		}
	}
}