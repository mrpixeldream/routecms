<?php
require_once(DIRNAME.'lib/pages/class/Page.php');
/*--------------------------------------------------------------------------------------------------
Datei      		 : Login.php
Beschreibung 	 : Admin Login Seite des Routecms
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 10.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class ErrorLogin extends Page {
	/**
	 * @see    Page::$template
	 */
	public $template = "errorLogin";
	/**
	 * @see    Page::$title
	 */
	public $title = "system.page.login";
}