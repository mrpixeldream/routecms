<?php
namespace routecms\actions;

use routecms\exception\PermissionExceptionAjax;
use routecms\Routecms;
use routecms\system\event\EventManger;

/*--------------------------------------------------------------------------------------------------
Datei      		 : Ajax.php
Beschreibung 	 : Eine Abstrakte Seite für Ajax Anforderungen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 25.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Ajax {
	/**
	 * Eine Liste mit berechtigungen die der User braucht um diese Aktion auszuführen
	 *
	 * @var array<string>
	 **/
	public $permissions = array();

	/**
	 * Erstellt eine neue Ajax Anforderungs Klassen
	 **/
	public function __construct() {

	}

	/**
	 * Starte die Ajax Anforderungs Klassen Funktionen
	 **/
	public function __run() {
		if(count($this->permissions) > 0) {
			if(!Routecms::checkPermissions($this->permissions)) {
				throw new PermissionExceptionAjax();
			}
		}
		$this->read();
		$this->action();
		$this->show();
	}

	/**
	 * Funktion liest die Paramater
	 **/
	public function read() {
		EventManger::event("read", get_class($this), $this);
	}

	/**
	 * Gibt Ajax Anforderungs Inhlt zurück als JSON Code
	 **/
	public function show() {
		$json = json_encode($this->getData());

		// send JSON response
		header('Content-type: application/json');
		echo $json;
		exit;
	}

	/**
	 * Gibt eine Variabel zurück die zurück gegeben werden soll bei der Ajax Anforderung
	 *
	 * @return mixed
	 **/
	public function getData() {

	}

	/**
	 * Führt die Funktion aus die bei der Ajax Anfrage gemacht werden sollte
	 **/
	public function action() {

	}
}