<?php
namespace routecms\system\user\group\optionType;

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOptionTypeBoolean.php
Beschreibung 	 : Gruppen Options Klasse für Boolean Optionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 27.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOptionTypeBoolean extends AbstractGroupOptionType {

	/**
	 * @see AbstractGroupOptionType::getValue()
	 */
	public function getValue() {
		foreach($this->getGroupValues() as $groupID => $value) {
			if($value == "1" || $value == 1) {
				return true;
			}
		}
		return false;
	}

}