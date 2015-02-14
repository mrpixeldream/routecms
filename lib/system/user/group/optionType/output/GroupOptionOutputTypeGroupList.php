<?php
require_once(DIRNAME.'lib/system/user/group/optionType/output/AbstractGroupOptionOutputType.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOptionOutputTypeGroupList.php
Beschreibung 	 : Gruppen Options Ausgabe Klasse für Boolean Optionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 08.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOptionOutputTypeGroupList extends AbstractGroupOptionOutputType {

	/**
	 * @see AbstractGroupOptionOutputType::getTemplate()
	 */
	public function getTemplate(){
		return "groupOptionGroupList";
	}

}