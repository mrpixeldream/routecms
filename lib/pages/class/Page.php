<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : Page.php
Beschreibung 	 : Die Template Seiten Klasse
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class Page {

	/**
	 * Die aktuelle Template Datei
	 *
	 * @var    string
	 */
	public $template = "";
	/**
	 * Eine Liste mit berechtigungen die der User braucht um diese Aktion auszuführen
	 *
	 * @var array<string>
	 **/
	public $permissions = array();
	/**
	 * Die aktuelle Seiten Title
	 *
	 * @var    string
	 */
	public $title = "";

	/**
	 * Erstellt eine neue Template Klassen Seite
	 **/
	public function __construct() {
	}

	/**
	 * Starte die Seiten Klassen Funktionen
	 **/
	public function __run() {
		if(count($this->permissions) > 0){
			if(!Routecms::checkPermissions($this->permissions)){
				throw new PermissionException();
			}
		}
		$this->read();	
		if(Input::isPost()) {
			$this->submit();
		}	
		$this->show();
	}

	/**
	 * Funktion liest die Paramater
	 **/
	public function read() {
		EventManger::event("read", get_class($this), $this);
		
	}

	/**
	 * Funktion liest die gesendeten Paramater
	 **/
	public function submit() {
		EventManger::event("submit", get_class($this), $this);
		$this->postRead();
		try {
			$this->validate();
			$this->save();
		}catch(Exception $ex) {

		}
	}

	/**
	 * Funktion liest die gesendeten Paramater
	 **/
	public function postRead() {
		EventManger::event("postRead", get_class($this), $this);
	}

	/**
	 * Überprüft die gesendeten Parameter
	 **/
	public function validate() {
		EventManger::event("validate", get_class($this), $this);
	}

	/**
	 * Speichert die eingegeben Parameter
	 **/
	public function save() {
		EventManger::event("save", get_class($this), $this);
	}

	/**
	 * Zeigt die aktuelle Seite an
	 **/
	public function show() {
		EventManger::event("show", get_class($this), $this);
		$this->assign();
		Routecms::getTemplate()->saveTemplate();
		EventManger::event("beforeShow", get_class($this), $this);
		Routecms::getTemplate()->showTemplate();
	}

	/**
	 * Übergibt dem Template die akteullen Variabeln
	 **/
	public function assign() {
		EventManger::event("assign", get_class($this), $this);
		Routecms::getTemplate()->assign(array('template' => $this->template,
			'title' => $this->title));
	}
}