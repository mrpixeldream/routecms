<?php
require_once(DIRNAME.'lib/actions/class/Ajax.php');
require_once(DIRNAME.'lib/exception/AjaxException.php');

/*--------------------------------------------------------------------------------------------------
Datei      		 : AjaxIllegalLink.php
Beschreibung 	 : Fehlerseite für eine Ajax Anfrage wenn die angegebe Seite nicht gefunden wurde
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 29.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class AjaxIllegalLink extends Ajax {
	/**
	 * @see Ajax::getData()
	 **/
	public function getData() {
		return array('title' => lang('exception.illegal.link'), 'description' => lang('exception.illegal.link.description'));
	}

	/**
	 * @see Ajax::show()
	 **/
	public function show() {
		@header('HTTP/1.0 404 Not Found');
		parent::show();
	}
}