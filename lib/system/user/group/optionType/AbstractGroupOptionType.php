<?php
namespace routecms\system\user\group\optionType;

use routecms\exception\SystemException;
use routecms\Routecms;
use routecms\system\user\group\GroupOption;

/*--------------------------------------------------------------------------------------------------
Datei      		 : AbstractGroupOptionType.php
Beschreibung 	 : Eine Abstrakte Klasse für Gruppen Optionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 27.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class AbstractGroupOptionType {
	/**
	 * Alle Groupen ID´s der Option für einen Bestimmten Benutzer
	 *
	 * @var array<integer>
	 */
	public $groupIDs = array();
	/**
	 * Die Aktulle Gruppen Option bei der Aktionen ausgeführt werden sollen
	 *
	 * @var GroupOption
	 */
	public $option = null;

	/**
	 * Erstellt eine neue Options Type Klasse
	 *
	 * @param GroupOption $option
	 * @param             array <integer> $groupIDs
	 */
	public function __construct(GroupOption $option, $groupIDs = array()) {
		if(!is_array($groupIDs) || count($groupIDs) == 0) {
			$this->groupIDs = Routecms::getUser()->getGroupIDs();
		}else {
			$this->groupIDs = $groupIDs;
		}
		$this->option = $option;
	}

	/**
	 * Erstellt eine neue Options Type Klasse
	 */
	protected function checkValid() {
		if(!($this->option instanceof GroupOption)) {
			throw new SystemException(lang("exception.system.error.instance.error"));
		}
	}

	/**
	 * Gibt die Variabel der Aktuellen Option zurück
	 *
	 * @return mixed
	 */
	public function getValue() {
	}

	/**
	 * Gibt in einer Array alle Inhalter der Option zurück
	 *
	 * @return array<mixed>
	 */
	protected function getGroupValues() {
		$values = array();
		foreach($this->groupIDs as $groupID) {
			$sql = "SELECT	value
			FROM	".DB_PREFIX."group_option_value
			WHERE	optionID = ? AND groupID = ?";
			$statement = Routecms::getDB()->statement($sql, 1);
			$statement->execute(array($this->option->optionID,
				$groupID));
			$row = $statement->fetchArray();
			if($row && isset($row["value"])) {
				$values[$groupID] = $row["value"];
			}
		}
		return $values;
	}
}