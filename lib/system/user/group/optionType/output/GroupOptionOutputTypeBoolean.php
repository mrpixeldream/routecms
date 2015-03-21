<?php
namespace routecms\system\user\group\optionType\output;

use routecms\Input;

/*--------------------------------------------------------------------------------------------------
Datei      		 : GroupOptionOutputTypeBoolean.php
Beschreibung 	 : Gruppen Options Ausgabe Klasse für Boolean Optionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 08.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class GroupOptionOutputTypeBoolean extends AbstractGroupOptionOutputType {

	/**
	 * @see AbstractGroupOptionOutputType::getTemplate()
	 */
	public function getTemplate() {
		return "groupOptionBoolean";
	}

	/**
	 * Ruft den Wert der Option ab
	 */
	protected function loadValue() {
		$values = Input::post("groupOptionValues", "array", array());
		if(isset($values[$this->option->name])) {
			$this->value = 1;
		}else {
			$this->value = 0;
		}
	}
}