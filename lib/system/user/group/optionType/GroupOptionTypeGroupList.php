<?php
namespace routecms\system\user\group\optionType;

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOptionTypeGroupList.php
Beschreibung 	 : Gruppen Options Klasse für Gruppen liste Optionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 27.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOptionTypeGroupList extends AbstractGroupOptionType {

	/**
	 * @see AbstractGroupOptionType::getValue()
	 */
	public function getValue() {
		$groupIDs = array();
		foreach($this->getGroupValues() as $groupID => $value) {
			foreach(explode("\n", $value) as $id) {
				if(!in_array($id, $groupIDs)) {
					$groupIDs[] = (int)$id;
				}
			}
		}
		return $groupIDs;
	}

}