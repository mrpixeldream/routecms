<?php
require_once(DIRNAME.'lib/system/user/group/GroupOption.php');
require_once(DIRNAME.'lib/system/user/group/Group.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : AbstractGroupOptionOutputType.php
Beschreibung 	 : Eine Abstrakte Klasse für Gruppen Optionen ausgabe
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 08.02.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class AbstractGroupOptionOutputType {
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
	 * Erstellt eine neue Options Type Klasse
	 *
	 * @param GroupOption $option
	 */
	public function __construct(GroupOption $option, Group $group) {
		$this->option = $option;
		$this->group = $group;
	}
	/**
	 * Übergibt dem Template Options Variablen
	 */
	public function assign(){
		Routecms::getTemplate()->assign(array('option_'.$this->option->optionID => $this->option));
	}
	/**
	 * Prüft ob die eingabe der Option korekt sind
	 *
	 * @param mixed $newValue
	 */
	public function validate($newValue){}

	/**
	 * Gibt die zuspeichernde Options Inhalt zurück
	 *
	 * @param mixed $newValue
	 *
	 * @return mixed
	 */
	public function getSaveValue($newValue){
		return $newValue;
	}
	/**
	 * Gibt den Template Namen zurück für diese Option
	 *
	 * @return string
	 */
	public function getTemplate(){}
}