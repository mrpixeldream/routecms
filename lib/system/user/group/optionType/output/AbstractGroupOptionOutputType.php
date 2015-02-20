<?php
namespace routecms\system\user\group\optionType\output;
use routecms\system\user\group\GroupOption;
use routecms\system\user\group\Group;
use routecms\Input;
use routecms\Routecms;

/*--------------------------------------------------------------------------------------------------
Datei      		 : AbstractGroupOptionOutputType.php
Beschreibung 	 : Eine Abstrakte Klasse für Gruppen Optionen ausgabe
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 08.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class AbstractGroupOptionOutputType{

	/**
	 * Die Aktulle Gruppen Option bei der Aktionen ausgeführt werden sollen
	 *
	 * @var GroupOption
	 */
	protected $option = null;
	/**
	 * Die Aktulle Gruppen Option bei der Aktionen ausgeführt werden sollen
	 *
	 * @var GroupOption
	 */
	protected $group = null;
	/**
	 * Von der Aktuellen Gruppe der Inhalt der Option
	 *
	 * @var mixed
	 */
	protected $value = null;
	/**
	 * Der Original Inhalt der Option
	 *
	 * @var mixed
	 */
	protected $originalValue = null;

	/**
	 * Erstellt eine neue Options Type Klasse
	 *
	 * @param GroupOption $option
	 * @param Group       $group
	 * @param boolean     $post
	 */
	public function __construct(GroupOption $option, Group $group, $post = false){
		$this->option = $option;
		$this->group = $group;
		$this->originalValue = $this->option->getValue($this->group->groupID);
		if($post){
			$this->loadValue();
		}else{
			$this->value = $this->originalValue;
		}
	}
	/**
	 * Ruft den Wert der Option ab
	 */
	protected function loadValue(){
		$this->value = Input::post("groupOptionValues[" . $this->option->name . "]", "");
	}

	/**
	 * Gibt den aktuellen Inhalt der Option zurück
	 */
	public function getValue(){
		return $this->value;
	}
	/**
	 * Prüft ob die eingabe der Option korekt sind
	 */
	public function validate(){ }

	/**
	 * Gibt die zuspeichernde Options Inhalt zurück
	 *
	 * @return mixed
	 */
	public function save(){
		if($this->originalValue != $this->value){
			$sql = "DELETE FROM	" . DB_PREFIX . "group_option_value
			WHERE		groupID = ? AND optionID = ?";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->group->groupID,
				$this->option->optionID));
			$sql = "INSERT INTO " . DB_PREFIX . "group_option_value (optionID, groupID, value) VALUES (?, ?, ?)";
			$statement = Routecms::getDB()->statement($sql);
			$statement->execute(array($this->option->optionID,
				$this->group->groupID,
				$this->value));
		}
	}
	/**
	 * Gibt den Template Namen zurück für diese Option
	 *
	 * @return string
	 */
	public function getTemplate(){ }
	/**
	 * Gibt das Template aus für diese Option
	 *
	 * @return string
	 */
	public function fetchTemplate(){
		return Routecms::getTemplate()->fetchTemplate($this->getTemplate(), "lib/admin/template/", true);
	}
}